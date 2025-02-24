<?php

namespace App\Controller;

use App\Entity\Cargo\Agent\Actor;
use App\Entity\Cargo\Core\Waybill;
use App\Entity\Cargo\Enum\EventTimeType;
use App\Service\FSUMessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FsuController extends AbstractController
{
    public function __construct(EntityManagerInterface $em,SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
//        $this->normalizer = $normalizer;
        $this->em = $em;
    }
    #[Route('/fsu/process', name: 'fsu_process')]
    public function fsu_process(): Response
    {

        $fsuMessageText = <<<EOT
FSU/12
901-00001875LAXNEW/T25
BKD/DNT212/16DEC/LAXNEW/T25K47500/S1000
EOT;

// Instantiate the processor with your message
        $fsuMessage = new FSUMessageService($fsuMessageText);

        $dateCreate = new \DateTime();
        $dateCreateStr = $dateCreate->format('Y-m-d\TH:i:s.v\Z');

        $dateEvent = \DateTime::createFromFormat('dMHi', $fsuMessage->flight->flight_date.$fsuMessage->flight->departure_time);
        $dateEventStr = $dateEvent->format('Y-m-d\TH:i:s.v\Z');

        $origin = $fsuMessage->flight->origin;

        $eventFor = "https://ordub.awery.com.ua/api/logistics-object/01953847-4239-7a9f-bd04-d8ee4379a1ae";

        $eventJson = <<<JSON
        {
          "eventCode": "$fsuMessage->status",
          "eventFor": "$eventFor",
          "eventLocation": "$origin",
          "eventTimeType": "$fsuMessage->status",
          "recordingOrganization": "https://ordub.awery.com.ua/",
          "creationDate": "$dateCreateStr",
          "eventDate": "$dateEventStr",
          "eventName": "BOOKED (The consignment has been booked for transport)",
          "partialEventIndicator": true
        }
        JSON;

//        dd($fsuMessage);





//        $id = "01953847-4239-7a9f-bd04-d8ee4379a1ae";
        $urlA = "https://ordub.awery.com.ua";

        $url = $urlA."/api/logistics-event";

        //https://ordub.awery.com.ua/api/logistics-object/01953847-4239-7a9f-bd04-d8ee4379a1ae
        //https://ordub.awery.com.ua/api/logistics-object/01953847-4239-7a9f-bd04-d8ee4379a1ae

//        dd($url);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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

        dd($response);

        //todo send to OneRecord main host
        return new Response('FSU message processed');
    }

    #[Route('/get/object/{id}', name: 'get_object')]
    public function get_object(Request $request, string $id): Response
    {
//        $id2 = $request->request->get('id');
//        dd($id);
        $id2 = "01953847-4239-7a9f-bd04-d8ee4379a1ae";
        $urlA = "https://ordub.awery.com.ua/api";

        $url = $urlA."/logistics-object/{$id}";

        dd($id, $id2, base64_decode($id));
//        $this->getRequest('hash')


        //hash

        dd(base64_encode($url));

        //https://ordub.awery.com.ua/api/logistics-object/01953847-4239-7a9f-bd04-d8ee4379a1ae
        //https://ordub.awery.com.ua/api/logistics-object/01953847-4239-7a9f-bd04-d8ee4379a1ae

//        dd($url);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>"{}",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/ld+json',
                'Accept: application/ld+json'
            ),
        ));
//
        $response = json_decode(curl_exec($curl));

//        $waibill = new Waybill();
//        $waibill->setWaybillNumber('123456');
//
//        $this->em->persist($waibill);
//        $this->em->flush();

        dd($response,222);

    }
    #[Route('/api/update', name: 'api_update_object', methods: ['POST'])]
    public function updateObject(Request $request):JsonResponse
    {

        $requestData = json_decode($request->getContent(), true);

        if ($requestData['@type'] === 'api:Notification') {
            $eventType = $requestData['api:hasEventType']['@id'];
            $logisticsObjectUrl = $requestData['api:hasLogisticsObject']['@id'];
            $objectType = $requestData['api:hasLogisticsObjectType']['@value'];

//            echo "Event Type: $eventType\n"; // Например: api:LOGISTICS_OBJECT_CREATED
//            echo "Logistics Object URL: $logisticsObjectUrl\n"; // URL объекта
//            echo "Object Type: $objectType\n"; // Тип объекта: cargo#Piece
        }

        if (!empty($objectType) && !empty($logisticsObjectUrl) && $objectType === 'cargo#Waybill') {
            // Обработка создания объекта типа cargo#Waybill
            // Например, создание объекта в базе данных

            $url = $logisticsObjectUrl;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS =>"{}",
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/ld+json',
                    'Accept: application/ld+json'
                ),
            ));

            $response = json_decode(curl_exec($curl));


        }


        return new JsonResponse([$logisticsObjectUrl,$objectType]);


        // Обработка создания ресурса
        $createdData = ['id' => 2, 'name' => $requestData['name']];

        return new JsonResponse($createdData, JsonResponse::HTTP_CREATED);
    }
}