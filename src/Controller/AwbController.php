<?php
namespace App\Controller;

use App\Entity\Awb;
use App\Entity\Event;
use App\Entity\PieceAwb;
use App\Service\FSUMessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AwbController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
//        $this->normalizer = $normalizer;
        $this->em = $em;
    }

    #[Route('/api/getAwbs', name: 'api_get_awbs', methods: ['GET'])]
    public function getAwbs(Request $request):JsonResponse
    {
        return new JsonResponse($this->em->getRepository(Awb::class)->findAll());
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

    #[Route('/api/updateEvent', name: 'api_update_event', methods: ['POST'])]
    public function updateEvent(Request $request):JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $Event = new Event();

        foreach ($requestData as $key => $value) {
            $Event->{$key} = $value;
        }
        $this->em->persist($Event);
        $this->em->flush();
        $id = $Event->getId();

        $this->sendToRed($id);

        return new JsonResponse(['id'=>$id]);
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