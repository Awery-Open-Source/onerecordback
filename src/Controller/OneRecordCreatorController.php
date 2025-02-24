<?php

namespace App\Controller;

use App\Entity\Awb;
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

class OneRecordCreatorController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
//        $this->normalizer = $normalizer;
        $this->em = $em;
    }

    #[Route('/api/sharing/create', name: 'api_create_awb_onerecord', methods: ['POST'])]
    public function createAwb($waybillUrl= null): Response
    {
//        $requestData = json_decode($request->getContent(), true);
//        if ($requestData['@type'] === 'api:Notification') {
//            $eventType = $requestData['api:hasEventType']['@id'];
//            $logisticsObjectUrl = $requestData['api:hasLogisticsObject']['@id'];
//            $objectType = $requestData['api:hasLogisticsObjectType']['@value'];
//        }
//        $url = $logisticsObjectUrl;

        $waybillUrl = "https://ordub.awery.com.ua/logistic-objects/01953a07-8e10-7380-882b-ba964949a8cf";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $waybillUrl,
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
        return new JsonResponse($response);
        $awb = new \stdClass();


        if ($response['@type'] === 'cargo:Waybill') {
            $awb->awb_no = $response['cargo:waybillPrefix'].'-'.$response['cargo:waybillNumber'];

            $shipmentUrl = $requestData['cargo:shipment']['@id'];

            $this->getShipment($shipmentUrl, $awb);

        }



        return new JsonResponse($awb);


    }

    public function getShipment($shipmentUrl, &$awb = null)
    {
        if (empty($awb)) $awb = new \stdClass();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $shipmentUrl,
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
        $awb->test = $response;
    }

}