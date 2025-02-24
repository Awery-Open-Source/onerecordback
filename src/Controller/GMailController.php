<?php

namespace App\Controller;

use Doctrine\DBAL\Exception;
use Google\Service\Gmail;
use Redis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Google;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class GMailController extends AbstractController
{
    public Google\Client $client;
    public Redis $redis;
    public string $redirect_uri = 'https://ordub.awery.com.ua/gmail/callback';
    private MailerInterface $mailer;

    /**
     * @throws Google\Exception
     * @throws \Exception
     */
    public function __construct(RequestStack $requestStack, MailerInterface $mailer)
    {
        $this->redis = new Redis();
        $this->redis->connect('localhost');
        $this->client = new Google\Client();
        $this->client->setAuthConfig(dirname(__DIR__, 2) . '/config/client.google.json');
        $this->client->addScope(Gmail::GMAIL_READONLY);
        $this->client->setPrompt('consent');
        $this->client->setAccessType('offline');

        $this->client->setRedirectUri($this->redirect_uri);

        $request = $requestStack->getCurrentRequest();
        if ($this->redis->exists($_ENV['REDIS_PREFIX'] . 'gmail_token') && $this->redis->exists($_ENV['REDIS_PREFIX'] . 'refresh_token')) {
            $this->client->setAccessToken($this->redis->get($_ENV['REDIS_PREFIX'] . 'gmail_token'));
            if (!empty($this->client->getRefreshToken()) || $this->client->isAccessTokenExpired()) {
                $newToken = $this->client->fetchAccessTokenWithRefreshToken($this->redis->get($_ENV['REDIS_PREFIX'] . 'refresh_token'));
                $this->client->setAccessToken($newToken);
                $this->redis->set($_ENV['REDIS_PREFIX'] . 'gmail_token', $newToken);
            }
        } else {
            $controllerInfo = $request->attributes->get('_controller');
            if (!in_array($controllerInfo, ['App\Controller\GMailController::loginGMail', 'App\Controller\GMailController::callbackAuth'])) {
                throw new \Exception('Gmail not authorized. Please authorize first', 44);
            }
        }
        $this->mailer = $mailer;
    }

    /**
     * @throws Exception
     */
    #[Route('/gmail/check', name: 'gmail')]
    public function checkGmailAuth(): void
    {
        if (!$this->redis->exists($_ENV['REDIS_PREFIX'] . 'gmail_token')) {
            throw new Exception('Gmail not authorized. Please authorize first', 44);
        }
    }

    #[Route('/gmail/component', name: 'gmail.component')]
    public function getGMAILComponent(): Response
    {
        return new JsonResponse([
            'error' => 0,
            'message' => 'Gmail',
            'data_list' => [
                'authorized' => $this->redis->exists($_ENV['REDIS_PREFIX'] . 'gmail_token')
            ]
        ]);
    }

    #[Route('/gmail/login', name: 'gmail.login')]
    public function loginGMail(): RedirectResponse
    {
        if ($this->redis->exists($_ENV['REDIS_PREFIX'] . 'gmail_token') && $this->redis->exists($_ENV['REDIS_PREFIX'] . 'refresh_token')) {
            return new RedirectResponse('https://ordub.awery.com.ua/gmail/get');
        }
        return new RedirectResponse(
            $this->client->createAuthUrl(
                Gmail::GMAIL_READONLY,
                ['access_type' => 'offline']
            )
        );
    }

    /**
     * @throws \Exception
     */
    #[Route('/gmail/callback', name: 'gmail.callback')]
    public function callbackAuth(Request $request): Response
    {
        if (empty($_GET['code'])) {
            throw new \Exception('No code provided', 400);
        }
        $googleCredentials = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (!empty($googleCredentials['access_token'])) {
            $this->redis->set($_ENV['REDIS_PREFIX'] . 'gmail_token', $googleCredentials['access_token']);
            $this->redis->set($_ENV['REDIS_PREFIX'] . 'refresh_token', $googleCredentials['refresh_token']);
            return new RedirectResponse('https://ordub.awery.com.ua/gmail/get');
        }

        return new JsonResponse([
            'error' => 1,
            'message' => 'Error while login',
            'data_list' => [
                'google_response' => $googleCredentials,
                'data' => $_GET
            ]
        ], 400);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    #[Route('/gmail/get', name: 'gmail.get')]
    public function getMails(Request $request): Response
    {
        $this->checkGmailAuth();
        $gmail = new Gmail($this->client);

        $data = (array)$request->getContent();
        $data['pageToken'] = $_GET['pageToken'] ?? null;// $this->checkEntryData($data, 'pageToken', 'string', true, 8);

        $messages = $gmail->users_messages->listUsersMessages('me', ['maxResults' => 25, 'pageToken' => $data['pageToken']]);
        if (!empty($messages)) {
            $messagesResult = array_map(function ($message) use ($gmail) {
                $gmailMessage = $gmail->users_messages->get('me', $message->id, ['format' => 'metadata', 'metadataHeaders' => ['Subject', 'From', 'Date']]);
                $headers = $gmailMessage->getPayload()->getHeaders();
                $resultData = [
                    'id' => $gmailMessage->id,
                    'short' => html_entity_decode($gmailMessage->getSnippet()),
                ];
                foreach ($headers as $header) {
                    $resultData[strtolower($header->name)] = $header->value;
                }
                $resultData['from'] = str_contains($resultData['from'], '<') ? substr($resultData['from'], 0, strpos($resultData['from'], '<') - 1) : $resultData['from'];
                $resultData['date'] = date('c', strtotime($resultData['date']));
                $resultData['show_date'] = date('Y-m-d') !== date('Y-m-d', strtotime($resultData['date']));
                return $resultData;
            }, $messages->getMessages());
        }

        return new JsonResponse([
            'error' => 0,
            'message' => 'getMails',
            'data_list' => [
                'messages' => $messagesResult ?? [],
                'nextPageToken' => $messages->getNextPageToken()
            ]
        ]);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    #[Route('/gmail/details', name: 'gmail.details')]
    public function getMailDetails(Request $request): Response
    {
        $data = $request->getContent();
        $data['email_id'] = $_GET['email_id'] ?? $data['email_id'] ?? null;// $this->checkEntryData($data, 'email_id', 'string', false, 15);
        if (empty($data['email_id'])) {
            throw new Exception('No email_id provided', 400);
        }

        $this->checkGmailAuth();
        $gmail = new Gmail($this->client);

        $gmailMessage = $gmail->users_messages->get('me', $data['email_id'], ['format' => 'full']);

        $headers = $gmailMessage->getPayload()->getHeaders();
        $resultData = [
            'id' => $gmailMessage->id,
            'short' => $gmailMessage->getSnippet(),
        ];
        foreach ($headers as $header) {
            if (!in_array($header->name, ['Subject', 'From', 'Date', 'To', 'Email-Id'])) {
                continue;
            }
            $resultData[strtolower($header->name)] = $header->value;
        }
        $resultData['date'] = date('c', strtotime($resultData['date']));

        $resultData['from_name'] = str_contains($resultData['from'], '<') ? substr($resultData['from'], 0, strpos($resultData['from'], '<') - 1) : $resultData['from'];
        $resultData['from_email'] = str_contains($resultData['from'], '<') ? substr($resultData['from'], strpos($resultData['from'], '<') + 1, -1) : $resultData['from'];

        $resultData['body'] = $gmailMessage->getPayload()->getBody()->getData();
        $parts = $gmailMessage->getPayload()->getParts();

        $bodyParts = array_values(array_filter($parts, function ($part) {
            return empty($part->filename);
        }));

        if (is_null($resultData['body']) && !empty($bodyParts)) {
            if (in_array('text/plain', array_column($bodyParts, 'mimeType'))) {
                $resultData['body'] = $bodyParts[array_search('text/plain', array_column($bodyParts, 'mimeType'))]->getBody()->getData();
            } else {
                $resultData['body'] = reset($bodyParts)->getBody()->getData();
            }
            $resultData['body'] = $this->gmailBodyDecode($resultData['body']);
        }

        $resultData['attachments'] = array_map(function ($part) use ($gmail, $gmailMessage) {
            $cid = $part->headers[array_search('Content-ID', array_column($part->headers, 'name'))];

            $attachmentData = $gmail->users_messages_attachments->get('me', $gmailMessage->id, $part->body->attachmentId);
            $decodedData = strtr($attachmentData['data'], array('-' => '+', '_' => '/'));

            return [
                'filename' => $part->filename,
                'mimeType' => $part->mimeType,
                'cid' => $cid ? (str_starts_with($cid['value'], '<') ? substr(substr($cid['value'], 1), 0, -1) : $cid['value']) : null,
                'content' => $part->body->data ?? $decodedData
            ];
        }, array_values(array_filter($parts, function ($part) {
            return !empty($part->filename);
        })));

        $attachments2Delete = [];
        foreach ($resultData['attachments'] as $key => $attachment) {


            if (str_contains($resultData['body'], $attachment['cid'])) {
                $resultData['body'] = str_replace('cid:' . $attachment['cid'], 'data:' . $attachment['mimeType'] . ';charset=utf-8;base64, ' . $attachment['content'], $resultData['body']);
                $resultData['body'] = str_replace('<a ', '<a target="_blank" ', $resultData['body']);
                $attachments2Delete[] = $key;
            }
        }

        if (!empty($attachments2Delete)) {
            foreach ($attachments2Delete as $key) {
                unset($resultData['attachments'][$key]);
            }
            $resultData['attachments'] = array_values($resultData['attachments']);
        }


        return new JsonResponse([
            'error' => 0,
            'message' => 'getMails',
            'data_list' => [
                'message' => $resultData
            ]
        ]);
    }

    private function gmailBodyDecode($data): false|string
    {
        $data = base64_decode(str_replace(array('-', '_'), array('+', '/'), $data));
//		$data = imap_qprint($data);
        return ($data);
    }

    /**
     * @throws \Exception
     */
    #[Route('/gmail/logout', name: 'gmail.logout')]
    public function logOutGMail(): JsonResponse
    {
        $this->redis->del($_ENV['REDIS_PREFIX'] . 'gmail_token');
        $this->redis->del($_ENV['REDIS_PREFIX'] . 'gmail_token');
        return new JsonResponse([
            'error' => 0,
            'message' => 'logOutGMail',
            'data_list' => [
                'authorized' => false
            ]
        ]);
    }

    /**
     * @throws \Exception
     * @throws TransportExceptionInterface
     */
    #[Route('/gmail/test', name: 'gmail.test')]
    public function testSend(): JsonResponse
    {
        return new JsonResponse([
            'error' => 0,
            'message' => 'testSend',
            'data_list' => []
        ]);
        $email = (new Email())
            ->from('noreply@awery.aero')
            ->to('mykola.p@awery.aero')
            ->subject('One more subject')
            ->html('Here will be a content');

        $this->mailer->send($email);

        return new JsonResponse([
            'error' => 0,
            'message' => 'testSend',
            'data_list' => []
        ]);
    }
}
