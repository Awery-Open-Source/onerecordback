<?php
namespace App\Controller;

use App\Entity\Awb;
use App\Entity\Event;
use App\Entity\PieceAwb;
use App\Service\FSUMessageService;
use DateMalformedStringException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AwbController extends AbstractController
{
    private EntityManagerInterface $em;
    private MailerInterface $mailer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, MailerInterface $mailer)
    {
        $this->serializer = $serializer;
//        $this->normalizer = $normalizer;
        $this->em = $em;
        $this->mailer = $mailer;
    }

    #[Route('/api/getAwbs', name: 'api_get_awbs', methods: ['GET'])]
    public function getAwbs(Request $request):JsonResponse
    {
        return new JsonResponse($this->em->getRepository(Awb::class)->findBy([], ['id' => 'DESC']));
    }

    #[Route('/api/updateAwb', name: 'api_update_awb', methods: ['POST'])]
    public function updateAwb(Request $request):JsonResponse
    {
        $id = 0;
        $requestData = json_decode($request->getContent(), true);
        if (!empty($requestData['id'])) {
            $setting = $this->em->getRepository(Awb::class)->find($requestData['id']);
        } else {
            $setting = new Awb();
        }
        if (!empty($setting)) {
            foreach ($requestData as $key => $value) {
                if ($key == 'id' || $key == 'pieces') {
                    continue;
                }
                $setting->{$key} = $value;
            }
            if (empty($requestData['id'])) {
                $this->em->persist($setting);
            }
            $this->em->flush();
            $id = $setting->getId();
        }
        if (!empty($id) && !empty($requestData['pieces'])) {
            foreach ($requestData['pieces'] as $piece) {
                $piece['awb_id'] = $id;
                $this->updatePiece($piece);
            }
        }
        return new JsonResponse(['status' => 'success', 'id' => $id]);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/getAwb', name: 'api_get_awb', methods: ['GET'])]
    public function getAwb(Request $request):JsonResponse
    {

        $awb_no = $request->query->get('awb_no');
        if (!empty($awb_no)) {
            $awb = $this->em->getRepository(Awb::class)->findOneBy(['awb_no' => $awb_no]);
        }
        if (empty($awb)) {
            throw new Exception('Invalid request');
        }

        $pieces = $this->em->getRepository(PieceAwb::class)->findBy(['awb_id' => $awb->getId()]);
        $events = $this->em->getRepository(Event::class)->findBy(['awb_id' => $awb->getId()]);
        return new JsonResponse(['status' => 'success', 'awb' => $awb, 'pieces' => $pieces, 'events' => $events]);
    }

    #[Route('/api/getPieces', name: 'api_get_pieces', methods: ['GET'])]
    public function getPieces(Request $request):JsonResponse
    {
        return new JsonResponse($this->em->getRepository(PieceAwb::class)->findAll());
    }

    protected function updatePiece($piece)
    {
        if (!empty($piece['id'])) {
            $Piece = $this->em->getRepository(PieceAwb::class)->find($piece['id']);
        } else {
            $Piece = new PieceAwb();
        }
        if (!empty($Piece)) {
            foreach ($piece as $key => $value) {
                if ($key == 'id') {
                    continue;
                }
                $Piece->{$key} = $value;
            }
            if (empty($piece['id'])) {
                $this->em->persist($Piece);
            }
            $this->em->flush();
        }
        return new JsonResponse(['status' => 'success']);
    }

    /**
     * @throws DateMalformedStringException
     */
    #[Route('/api/updateEvent', name: 'api_update_event', methods: ['POST'])]
    public function updateEvent(Request $request):JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $Event = new Event();

        foreach ($requestData as $key => $value) {
            $Event->{$key} = str_starts_with($key, 'date') ? new DateTime($value) : $value;
        }
        try {
            $this->em->persist($Event);
            $this->em->flush();
            $id = $Event->getId();
        }catch (Exception $e){
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()]);
        }

        $this->sendToRed($id);

        return new JsonResponse(['id'=>$id]);
    }

    public function sendToSubscribers($id_event = 0)
    {
        if (empty($id_event)) {
            return false;
        }

        $query = $this->em->createQuery(
            'SELECT email FROM settings WHERE email IS NOT NULL'
        );
        $usersWithEmail = $query->getResult();

        $message = FSUMessageService::generateFsu($id_event, $this->em);

        foreach ($usersWithEmail as $user){
            $email = (new Email())
                ->from('noreply@awery.aero')
                ->to($user)
                ->subject('FSU Message')
                ->html($message);
            $this->mailer->send($email);
        }

    }

    public function sendToRed($id_fsu_message = 0)
    {
        if (empty($id_fsu_message)) {
            return false;
        }
        $fsuMessage = $this->em->getRepository(Event::class)->find($id_fsu_message);
        $awb = $this->em->getRepository(Awb::class)->find($fsuMessage->awb_id);
        $redServer = getenv('RED_SERVER', 'https://red.awery.com.ua');
        $eventName = FSUMessageService::getDescOfStatus($fsuMessage->type) ?? 'Unknown';
        $eventJson = <<<JSON
        {
          "eventCode": "$fsuMessage->type",
          "eventFor": "$awb->one_record_url",
          "eventLocation": "$fsuMessage->flight->origin",
          "eventTimeType": "$fsuMessage->type",
          "recordingOrganization": "$redServer",
          "creationDate": "$fsuMessage->dateCreate",
          "eventDate": "$fsuMessage->dateAction",
          "eventName": "$eventName",
          "partialEventIndicator": true
        }
        JSON;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $awb->one_record_url."/logistics-events",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$eventJson,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/ld+json',
                'Accept: application/ld+json'
            ),
        ));
//
        $response = json_decode(curl_exec($curl));

        $headers = $this->getHeaders($response);

        $fsuMessage->one_record_id = $headers['Location'];
        $this->em->flush();
        return ['id'=>$fsuMessage->id];
    }

    private function getHeaders($response): array
    {
        $headers = array();
        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
        foreach (explode("\r\n", $header_text) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }
        }
        return $headers;
    }
}
