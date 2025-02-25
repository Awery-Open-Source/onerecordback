<?php
namespace App\Controller;

use App\Entity\Awb;
use App\Entity\Cargo\Abstract\LogisticsObject;
use App\Entity\Cargo\Common\Location;
use App\Entity\Cargo\Core\Piece;
use App\Entity\Cargo\Core\Shipment;
use App\Entity\Cargo\Core\Waybill;
use App\Entity\Cargo\Embedded\Dimensions;
use App\Entity\Cargo\Embedded\Value;
use App\Entity\Cargo\Enum\EventTimeType;
use App\Entity\Cargo\Event\LogisticsEvent;
use App\Entity\CoreCodeLists\MeasurementUnitCode;
use App\Entity\Event;
use App\Entity\PieceAwb;
use App\Entity\Settings;
use App\Service\FSUMessageService;
use DateMalformedStringException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use stdClass;
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
        $gr_w = 0;
        $shipment = new Shipment();
        $shipment->setGoodsDescription('shipment description');
        if (!empty($id) && !empty($requestData['pieces'])) {

            foreach ($requestData['pieces'] as $piece) {
                $piece['awb_id'] = $id;
                $this->updatePiece($piece);
                $gr_w+=$piece['weight'];



                $height = new Value();
                $height->setNumericalValue($piece['height']);
                $height->setUnit(MeasurementUnitCode::CMT);
                $length = new Value();
                $length->setNumericalValue($piece['length']);
                $length->setUnit(MeasurementUnitCode::CMT);
                $width = new Value();
                $width->setNumericalValue($piece['width']);
                $width->setUnit(MeasurementUnitCode::CMT);
                $dimension = new Dimensions();
                $dimension->setHeight($height);
                $dimension->setLength($length);
                $dimension->setWidth($width);
                $this->em->persist($height);
                $this->em->persist($length);
                $this->em->persist($width);
                $this->em->persist($dimension);
                $piece2 = new Piece();
                $piece2->setUpid(rand(9879887,87651486545));
                $piece2->setDimensions($dimension);
                $this->em->persist($piece2);
                $shipment->addPieces($piece2);
            }
        }
        $gr_weight = new Value();
        $gr_weight->setNumericalValue($gr_w);
        $gr_weight->setUnit(MeasurementUnitCode::KGM);
        $shipment->setTotalGrossWeight($gr_weight);
        $waybill = new Waybill();
        $tmp = explode('-', $requestData['awb_no']);
        $waybill->setWaybillPrefix($tmp[0]);
        $waybill->setWaybillNumber($tmp[1]);

        $location = new Location();
        $location->setLocationName($requestData['origin']);
        $location->setLocationType('airport');
        $location1 = new Location();
        $location1->setLocationName($requestData['destination']);
        $location1->setLocationType('airport');
        $waybill->setDepartureLocation($location);
        $waybill->setArrivalLocation($location1);

        $shipment->setWaybill($waybill);
        $waybill->setShipment($shipment);

        $this->em->persist($shipment);
        $this->em->persist($waybill);
        $this->em->persist($location1);
        $this->em->persist($location);
        $this->em->persist($gr_weight);

        $le = new LogisticsEvent();
        $le->setCreationDate(new \DateTime());
        $le->setEventCode('CRE');
        $le->setEventDate(new \DateTime());
        $le->setEventName('Created');
        $le->setEventTimeType(EventTimeType::ACTUAL);
        $setting->one_record_url = 'http://'.$_SERVER['HTTP_HOST'].'/logistic-objects/'.$waybill->getId();
        $le->setEventFor($waybill);
        $this->em->persist($le);
        $this->em->flush();

        $lo_path = 'http://'.$_SERVER['HTTP_HOST'].'/logistic-objects/';

        $send_obj = new \stdClass();
        $send_obj->{'@context'} = (object) ['api' => 'https://onerecord.iata.org/ns/api#'];
        $send_obj->{'@type'} = 'api:Notification';
        $send_obj->{'api:hasEventType'} = (object) ['@id' => 'api:LOGISTICS_OBJECT_CREATED'];
        $send_obj->{'api:hasLogisticsObject'} = (object) ['@id' => $lo_path.$waybill->getId()];
        $send_obj->{'api:hasLogisticsObjectType'} = (object) [
            '@type' => 'http://www.w3.org/2001/XMLSchema#anyURI',
            '@value' => 'https://onerecord.iata.org/ns/cargo#Shipment'
        ];

        $subscriptions = $this->em->getRepository(Settings::class)
            ->createQueryBuilder('s')
            ->where('s.token IS NOT NULL')
            ->andWhere('s.token != :empty')
            ->setParameter('empty', '')
            ->getQuery()
            ->getResult();

        $curl = curl_init();
        foreach ($subscriptions as $subscription) {
            $remote_url = $subscription->base_url . '/api/update';
            curl_setopt_array($curl, array(
                CURLOPT_URL => $remote_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($send_obj),
                CURLOPT_HTTPHEADER => array(
                    'token: ' . $subscription->token,
                    'Content-Type: application/json',
                ),
            ));
            curl_exec($curl);
        }
        curl_close($curl);

        return new JsonResponse(['status' => 'success', 'id' => $id, 'logistics_object_id' => $waybill->getId(), 'sub' => $subscriptions]);
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
        $awb = $this->em->getRepository(Awb::class)->find($requestData['awb_id']);
        $tmp = explode('/', $awb->one_record_url);
        $waybill = $this->em->getRepository(LogisticsObject::class)->find(end($tmp));


        $le = new LogisticsEvent();
        $le->setCreationDate(new \DateTime($requestData['dateCreate']));
        $le->setEventCode($requestData['type']);

        $le->setEventDate(new \DateTime($requestData['dateAction']));
        $le->setEventName('Update');
        $le->setEventTimeType(EventTimeType::ACTUAL);
//
        $le->setEventFor($waybill);
        $this->em->persist($le);
        $this->em->flush();
        $location = new Location();
        $location->setLocationName($requestData['location']);
        $location->setLocationType('airport');
        $this->em->persist($location);
        $le->setEventLocation($location);
        $this->em->flush();
//        dump($lo_url);die;
        $this->sendToRed($id);

        return new JsonResponse(['id'=>$id, 'status' => 'success']);
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
        //DateTime to sting
        $dateCreateStr = $fsuMessage->dateCreate->format('Y-m-d H:i:s');
        $dateEventStr = $fsuMessage->dateAction->format('Y-m-d H:i:s');
        $enum = \App\Entity\Cargo\Enum\EventTimeType::ACTUAL;
        $eventJson = <<<JSON
        {
          "eventCode": "$fsuMessage->type",
          "eventFor": "$awb->one_record_url",
          "eventLocation": "$fsuMessage->location",
          "eventTimeType": "ACTUAL",
          "recordingOrganization": "$redServer",
          "creationDate": "$dateCreateStr",
          "eventDate": "$dateEventStr",
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
            CURLOPT_HEADER => 1,
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
        $response = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $http_body = substr($response, $header_size);
        $header = substr($response, 0, $header_size);
        $response = json_decode($http_body, true);
        $headers = $this->getHeaders($header);

        $fsuMessage->one_record_id = $headers['Location']??null;
        $this->em->flush();
        return ['id'=>$fsuMessage->id];
    }

    private function getHeaders($response): array
    {
        $headers = array();
        if (!is_string($response)) return $headers;
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
