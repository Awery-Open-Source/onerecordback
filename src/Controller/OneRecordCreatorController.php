<?php

namespace App\Controller;

use App\Entity\Awb;
use App\Entity\Cargo\Agent\Actor;
use App\Entity\Cargo\Core\Waybill;
use App\Entity\Cargo\Enum\EventTimeType;
use App\Entity\PieceAwb;
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

//        $waybillUrl = "https://ordub.awery.com.ua/logistic-objects/01953a07-8e10-7380-882b-ba964949a8cf";

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

        $response = json_decode(curl_exec($curl), true);
        $awb = new \stdClass();



        if ($response['@type'] === 'cargo:Waybill') {
            $awb->awb_no = $response['cargo:waybillPrefix'].'-'.$response['cargo:waybillNumber'];
            $awb->one_record_url = $waybillUrl;

            $shipmentUrl = $response['cargo:shipment']['@id'];

            $this->getShipment($shipmentUrl, $awb);

        }
        if (!empty($response['cargo:arrivalLocation'])) {
            $this->getAwbLocation($response['cargo:arrivalLocation']['@id'], $awb);
        }
        if (!empty($response['cargo:departureLocation'])) {
            $this->getAwbLocation($response['cargo:departureLocation']['@id'], $awb, true);
        }
        $setting = new Awb();
        foreach ($awb as $key => $value) {
            if ($key == 'id' || $key == 'pieces') {
                continue;
            }
            $setting->{$key} = $value;
        }
        $this->em->persist($setting);
        $this->em->flush();
        $id = $setting->getId();
        if (!empty($id) && !empty($awb->pieces)) {
            foreach ($awb->pieces as $piece) {
                $piece->awb_id = $id;
                $this->updatePiece($piece);
            }
        }

        return new JsonResponse($awb);
    }

    public function updatePiece($piece)
    {
        $Piece = new PieceAwb();
        foreach ($piece as $key => $value) {
            if ($key == 'id') {
                continue;
            }
            $Piece->{$key} = $value;
        }
        $this->em->persist($Piece);
        $this->em->flush();
    }

    public function getAwbLocation($locationUrl, &$awb = null, $origin = false)
    {
        if (empty($awb)) $awb = new \stdClass();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $locationUrl,
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
        $response = json_decode(curl_exec($curl), true);
        if ($origin) {
            $awb->origin = $response['cargo:locationName'];
        } else {
            $awb->destination = $response['cargo:locationName'];
        }

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
        $response = json_decode(curl_exec($curl), true);

        $awb->weight = $response['cargo:totalGrossWeight']['cargo:numericalValue'];
        if (!empty($response['cargo:pieces'])) {
            foreach ($response['cargo:pieces'] as $piece) {
                $this->getPiece($piece['@id'], $awb);
            }
        }


        return $awb;
    }

    public function getPiece($pieceUrl, &$awb=null)
    {
        if (empty($awb)) $awb = new \stdClass();
        if (empty($awb->pieces)) $awb->pieces = [];
        $piece = new \stdClass();
        if (empty($awb)) $awb = new \stdClass();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $pieceUrl,
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
        $response = json_decode(curl_exec($curl), true);
        $piece->height = $response['cargo:dimensions']['cargo:height']['cargo:numericalValue'];
        $piece->length = $response['cargo:dimensions']['cargo:length']['cargo:numericalValue'];
        $piece->width = $response['cargo:dimensions']['cargo:width']['cargo:numericalValue'];
        $piece->one_record_id = $pieceUrl;
        $awb->pieces[] = $piece;
//        $awb->test = $response;
    }

}