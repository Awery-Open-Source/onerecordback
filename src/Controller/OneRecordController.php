<?php
namespace App\Controller;

use App\Entity\Cargo\Common\Location;
use App\Entity\Cargo\Core\Piece;
use App\Entity\Cargo\Core\Shipment;
use App\Entity\Cargo\Core\Waybill;
use App\Entity\Cargo\Embedded\Dimensions;
use App\Entity\Cargo\Embedded\Value;
use App\Entity\Cargo\Enum\EventTimeType;
use App\Entity\CoreCodeLists\MeasurementUnitCode;
use App\Serializer\OneRecordNormalizer;
use App\Serializer\OrNormalizer;
use App\Service\OneRecordParser;
use ReflectionClass;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cargo\Abstract\LogisticsObject;
use App\Entity\Cargo\Event\LogisticsEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

//use App\Entity\Subscription;
//use App\Entity\ActionRequest;
//use App\Entity\AccessDelegation;

/**
 * @property OrNormalizer $normalizer
 */
class OneRecordController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private OrNormalizer $normalizer;

    public function __construct(EntityManagerInterface $entityManager,SerializerInterface $serializer, OrNormalizer $normalizer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
    }

    #[Route('/create', name: 'create', methods: ['GET'])]
    public function create(): JsonResponse
    {
        $le = new LogisticsEvent();
        die;
        $le->setCreationDate(new \DateTime());
        $le->setEventCode('CDD');
        $le->setEventDate((new \DateTime())->modify('+2day'));
        $le->setEventName('EventName');
        $le->setEventTimeType(EventTimeType::EXPECTED);

//        $projectDir = $this->getParameter('kernel.project_dir');
//        $orp = new OneRecordParser($projectDir, '/src/Entity/','App\Entity\\');
//        $enumlist = $orp->coreCodeLists();
//
//        $orp->cargo();
        $height = new Value();
        $height->setNumericalValue(5);
        $height->setUnit(MeasurementUnitCode::CMT);
        $length = new Value();
        $length->setNumericalValue(2);
        $length->setUnit(MeasurementUnitCode::CMT);
        $width = new Value();
        $width->setNumericalValue(3);
        $width->setUnit(MeasurementUnitCode::CMT);

        $volume = new Value();
        $volume->setNumericalValue(30);
        $volume->setUnit(MeasurementUnitCode::CMQ);

        $dimension = new Dimensions();
        $dimension->setHeight($height);
        $dimension->setLength($length);
        $dimension->setWidth($width);
        $dimension->setVolume($volume);

        $piece = new Piece();
        $piece->setUpid('rangomupid');
        $piece->setTextualHandlingInstructions(['instruction 1', 'instruction 2']);
        $piece->setDimensions($dimension);
        $piece2 = new Piece();
        $piece2->setUpid('rangomupid2');
        $piece2->setDimensions($dimension);


        $shipment = new Shipment();
        $shipment->setGoodsDescription('GoodsDescription');
        $gr_weight = new Value();
        $gr_weight->setNumericalValue(1.5);
        $gr_weight->setUnit(MeasurementUnitCode::KGM);
        $shipment->setTotalGrossWeight($gr_weight);
        $shipment->addPieces($piece);
        $shipment->addPieces($piece2);
//
        $waybill = new Waybill();
        $waybill->setWaybillPrefix('588');
        $waybill->setWaybillNumber('549845');

        $location = new Location();
        $location->setLocationName('Dublin');
        $location->setLocationType('airport');
        $location1 = new Location();
        $location1->setLocationName('Sofia');
        $location1->setLocationType('airport');
        $waybill->setDepartureLocation($location);
        $waybill->setArrivalLocation($location);
        $shipment->setWaybill($waybill);
        $waybill->setShipment($shipment);
        $this->entityManager->persist($shipment);
        $this->entityManager->persist($waybill);
        $this->entityManager->persist($location1);
        $this->entityManager->persist($location);
        $this->entityManager->persist($gr_weight);
        $this->entityManager->persist($piece);
        $this->entityManager->persist($piece2);
        $this->entityManager->persist($dimension);
        $this->entityManager->persist($volume);
        $this->entityManager->persist($width);
        $this->entityManager->persist($height);
        $this->entityManager->persist($length);

        $le->setEventFor($waybill);
        $this->entityManager->persist($le);
        $this->entityManager->flush();
        dump($waybill);die;
        $serializer = new Serializer([$this->normalizer], [new JsonEncoder()]);
//        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
//        dump($person);die;
        $onerecord_data = $serializer->serialize($shipment, 'json');
        return $this->json(json_decode($onerecord_data));
    }

    /**
     * GET /logistics-objects/{logisticsObjectId}
     */
    #[Route('/logistic-objects/{logisticsObjectId}', name: 'one_record_get_logistics_object', methods: ['GET'])]
    public function getLogisticsObject(string $logisticsObjectId): JsonResponse
    {
//        return $this->sendNotification($logisticsObjectId);
        $lo_path = 'http://'.$_SERVER['HTTP_HOST'].'/logistic-objects/';
        $object = $this->entityManager->getRepository(LogisticsObject::class)->find($logisticsObjectId);
        if (!$object) {
            return $this->json(['error' => 'Logistics Object not found'], 404);
        }
        $serializer = new Serializer([$this->normalizer], [new JsonEncoder()]);
        $jsonData = $serializer->serialize($object,'json');
        $jsonObject = json_decode($jsonData);
//        dump($object);die;
        if(property_exists($object,'shipment')){
            $jsonObject->{'cargo:shipment'} = (object)['@id'=>$lo_path.$object->getShipment()->getId()];
        }
        if(property_exists($object,'arrivalLocation')){
            $jsonObject->{'cargo:arrivalLocation'} = (object)['@id'=>$lo_path.$object->getArrivalLocation()->getId()];
        }
        if(property_exists($object,'departureLocation')){
            $jsonObject->{'cargo:departureLocation'} = (object)['@id'=>$lo_path.$object->getDepartureLocation()->getId()];
        }
        if(property_exists($object,'waybill')){
            $jsonObject->{'cargo:waybill'} = (object)['@id'=>$lo_path.$object->getWaybill()->getId()];
        }
        if(property_exists($jsonObject,'cargo:events')){
            unset($jsonObject->{'cargo:events'});
        }
        foreach ($jsonObject as $field => $value) {
            if($field == '@context'){
                continue;
            }
            if(is_object($value)) {
                $no = new stdClass();
                foreach ($value as $vk => $vv) {
                    if($vk == '@id'){
                        $no->{'@id'} = $vv;
                        continue;

                    }
                    if($vk == '@type'){
                        $no->{'@type'} = $vv;
                        continue;
                    }
                    $no->{'cargo:'.$vk} = $vv;
                    if(str_contains($vv,'/api/value/')){
//                        dump(basename($vv));
                        $ent = $this->entityManager->getRepository(Value::class)->find(basename($vv));
                        $this->entityManager->initializeObject($ent);
                        $val = new stdClass();
                        $val->{'@type'} = 'Value';
                        $val->{'cargo:unit'} = $ent->getUnit()->value;
                        $val->{'cargo:numericalValue'} = $ent->getNumericalValue();
                        $no->{'cargo:'.$vk} = $val;
                    }
                }
                $jsonObject->{$field} = $no;
            } elseif (is_array($value)) {
                if(empty($value)) {
                    unset($jsonObject->{$field});
                } else {
                    foreach ($value as $k => $v) {
                        if(!empty($v->{'@id'})){
//                            $v->{'@id'} = 'https://ordub.awery.com.ua/logistic-objects/'.$v->{'@id'};
                            $v->{'@id'} = $lo_path.$v->{'@id'};
                        }
                    }
                }
            }

        }
        return new JsonResponse(json_encode($jsonObject), 200, ['Content-Type' => 'application/ld+json'], true);
    }
    #[Route('/logistic-objecstss/sendNotification', name: 'sendNotification', methods: ['GET'])]
    public function sendNotification($logisticsObjectId, $type = 'LOGISTICS_OBJECT_CREATED')
    {
        $lo_path = 'http://'.$_SERVER['HTTP_HOST'].'/logistic-objects/';
        $remotedomain = 'http://server2.com/notification';
        $object = $this->entityManager->getRepository(LogisticsObject::class)->find($logisticsObjectId);
        $tmp = explode('\\',get_class($object));
        $send_obj = new stdClass();
        $send_obj->{'@context'} = (object) ['api' => 'https://onerecord.iata.org/ns/api#'];
        $send_obj->{'@type'} = 'api:Notification';
        $send_obj->{'api:hasEventType'} = (object) ['@id' => 'api:'.$type];
        $send_obj->{'api:hasLogisticsObject'} = (object) ['@id' => $lo_path.$logisticsObjectId];
        $send_obj->{'api:hasLogisticsObjectType'} = (object) [
            '@type' => 'http://www.w3.org/2001/XMLSchema#anyURI',
            '@value' => 'https://onerecord.iata.org/ns/cargo#'.end($tmp)
        ];
        echo json_encode($send_obj);die;

    }
//
//    /**
//     * 🔹 POST /logistics-objects/
//     * Создание логистического объекта
//     */
//    #[Route('/', name: 'create_logistics_object', methods: ['POST'])]
//    public function createLogisticsObject(Request $request): JsonResponse
//    {
//        $data = json_decode($request->getContent(), true);
//
//        if (!$data) {
//            return $this->json(['error' => 'Invalid JSON'], 400);
//        }
//
//        $object = new LogisticsObject();
//        $object->setName($data['name'] ?? 'Unnamed Object');
//        $this->entityManager->persist($object);
//        $this->entityManager->flush();
//
//        return $this->json($object, 201, ['Content-Type' => 'application/ld+json']);
//    }
//
//    /**
//     * 🔹 GET /logistics-objects/{logisticsObjectId}/audit-trail
//     * Получение истории изменений логистического объекта
//     */
//    #[Route('/{logisticsObjectId}/audit-trail', name: 'get_audit_trail', methods: ['GET'])]
//    public function getAuditTrail(string $logisticsObjectId): JsonResponse
//    {
//        // Логика получения истории изменений...
//        return $this->json(['message' => 'Audit trail for Logistics Object ' . $logisticsObjectId]);
//    }
//
    /**
     * 🔹 GET, POST /logistics-objects/{logisticsObjectId}/logistics-events
     * Получение/Создание событий
     */
    #[Route('/logistic-objects/{logisticsObjectId}/logistics-events', name: 'logistics_events', methods: ['GET', 'POST'])]
    public function logisticsEvents(Request $request, string $logisticsObjectId): JsonResponse
    {
        $lo_path = 'http://'.$_SERVER['HTTP_HOST'].'/logistic-objects/';
        if ($request->isMethod('POST')) {
            $data = json_decode($request->getContent(), true);

            if (!$data) {
                return $this->json(['error' => 'Invalid JSON'], 400);
            }

            $le = new LogisticsEvent();
            $le->setCreationDate(new \DateTime($data['creationDate']));
            $le->setEventCode($data['eventCode']);
            $le->setEventDate((new \DateTime($data['eventDate'])));
            $le->setEventName($data['eventName']);
            $le->setEventTimeType(EventTimeType::{$data['eventTimeType']});
            $logisticsObject = $this->entityManager->getRepository(LogisticsObject::class)->find($logisticsObjectId);
            $le->setEventFor($logisticsObject);
            $this->entityManager->persist($le);
            $this->entityManager->flush();

            return new JsonResponse(
                null,
                JsonResponse::HTTP_CREATED, // 201 Created
                [
                    'Location' => $lo_path.$logisticsObjectId.'/logistics-events/'.$le->getId(),
                    'Content-Type' => 'application/ld+json; version=2.1.0',
                    'Type' => 'https://onerecord.iata.org/ns/cargo#LogisticsEvent',
                ]
            );
        }
        if ($request->isMethod('GET')) {
            $jsonObject = new stdClass();
            $jsonObject->{'@context'} = new stdClass();
            $jsonObject->{'@context'}->cargo = "https://onerecord.iata.org/ns/cargo#";
            $jsonObject->{'@context'}->api = "https://onerecord.iata.org/ns/api#";
            $jsonObject->{'@id'} = $lo_path.$logisticsObjectId.'/logistics-events';
            $jsonObject->{'@type'} = 'api:Collection';


            $logisticsObject = $this->entityManager->getRepository(LogisticsObject::class)->find($logisticsObjectId);
            $events = $this->entityManager->getRepository(LogisticsEvent::class)->findBy(['eventFor' => $logisticsObjectId]);
            $jsonObject->{'api:hasTotalItems'} = count($events);
            $jsonObject->{'api:hasItem'} = [];
            $serializer = new Serializer([$this->normalizer], [new JsonEncoder()]);
            $jsobj =  json_decode($serializer->serialize($logisticsObject, 'json'));

            foreach ($events as $event) {
                $jsevent =  json_decode($serializer->serialize($event, 'json'));

                $id = $lo_path.$logisticsObjectId.'/logistics-events/'.basename($jsevent->{'@id'});
                $jsevent->{'@id'} = $id;
                $jsevent->{'cargo:creationDate'} = (object)[
                    '@type'=>'http://www.w3.org/2001/XMLSchema#dateTime',
                    '@value'=>$jsevent->{'cargo:creationDate'},
                ];
                $jsevent->{'cargo:eventDate'} = (object)[
                    '@type'=>'http://www.w3.org/2001/XMLSchema#dateTime',
                    '@value'=>$jsevent->{'cargo:eventDate'},
                ];
                $jsevent->{'cargo:linkedObject'} = (object)[
                    '@id'=>$jsobj->{'@id'},
                    '@type'=>$jsobj->{'@type'},
                ];
                unset($jsevent->{'@context'});

                $jsonObject->{'api:hasItem'}[] = $jsevent;
            }
        }
        return new JsonResponse(json_encode($jsonObject), 200, ['Content-Type' => 'application/ld+json'], true);
    }

    #[Route('/logistic-objects/{logisticsObjectId}/logistics-events/{logisticsEventId}', name: 'logistics_events_one', methods: ['GET', 'POST'])]
    public function logisticsEventsOne(Request $request, string $logisticsObjectId, string $logisticsEventId): JsonResponse
    {
        $lo_path = 'http://'.$_SERVER['HTTP_HOST'].'/logistic-objects/';
        $logisticsObject = $this->entityManager->getRepository(LogisticsObject::class)->find($logisticsObjectId);

        $event = $this->entityManager->getRepository(LogisticsEvent::class)->find($logisticsEventId);
        $serializer = new Serializer([$this->normalizer], [new JsonEncoder()]);
        $jsobj =  json_decode($serializer->serialize($logisticsObject, 'json'));
        $jsevent =  json_decode($serializer->serialize($event, 'json'));
        $id = $lo_path.$logisticsObjectId.'/logistics-events/'.basename($jsevent->{'@id'});
        $jsevent->{'@id'} = $id;
        $jsevent->{'cargo:creationDate'} = (object)[
            '@type'=>'http://www.w3.org/2001/XMLSchema#dateTime',
            '@value'=>$jsevent->{'cargo:creationDate'},
        ];
        $jsevent->{'cargo:eventDate'} = (object)[
            '@type'=>'http://www.w3.org/2001/XMLSchema#dateTime',
            '@value'=>$jsevent->{'cargo:eventDate'},
        ];
        $jsevent->{'cargo:linkedObject'} = (object)[
            '@id'=>$jsobj->{'@id'},
            '@type'=>$jsobj->{'@type'},
        ];
        return new JsonResponse(json_encode($jsevent), 200, ['Content-Type' => 'application/ld+json'], true);
    }
//
//    /**
//     * 🔹 POST /subscriptions
//     * Создание подписки
//     */
    #[Route('/subscriptions', name: 'subscriptions', methods: ['POST'])]
    public function createSubscription(Request $request): JsonResponse
    {
//        $data = json_decode($request->getContent(), true);
//
//        if (!$data) {
//            return $this->json(['error' => 'Invalid JSON'], 400);
//        }
//
//        $subscription = new Subscription();
//        $subscription->setSubscriber($data['subscriber'] ?? 'Anonymous');
//
//        $this->entityManager->persist($subscription);
//        $this->entityManager->flush();

        return $this->json(1, 201);
    }
//
//    /**
//     * 🔹 POST /notifications
//     * Получение уведомлений
//     */
//    #[Route('/notifications', name: 'notifications', methods: ['POST'])]
//    public function receiveNotification(Request $request): JsonResponse
//    {
//        $data = json_decode($request->getContent(), true);
//        return $this->json(['message' => 'Notification received', 'data' => $data]);
//    }
//
//    /**
//     * 🔹 POST /access-delegations
//     * Запрос на делегирование доступа
//     */
//    #[Route('/access-delegations', name: 'access_delegations', methods: ['POST'])]
//    public function accessDelegation(Request $request): JsonResponse
//    {
//        $data = json_decode($request->getContent(), true);
//
//        if (!$data) {
//            return $this->json(['error' => 'Invalid JSON'], 400);
//        }
//
//        $delegation = new AccessDelegation();
//        $delegation->setRequester($data['requester'] ?? 'Unknown');
//
//        $this->entityManager->persist($delegation);
//        $this->entityManager->flush();
//
//        return $this->json($delegation, 201);
//    }
}
