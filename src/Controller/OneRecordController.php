<?php
namespace App\Controller;

use App\Entity\Cargo\Core\Piece;
use App\Entity\Cargo\Core\Shipment;
use App\Entity\Cargo\Embedded\Dimensions;
use App\Entity\Cargo\Embedded\Value;
use App\Entity\CoreCodeLists\MeasurementUnitCode;
use App\Serializer\OneRecordNormalizer;
use App\Serializer\OrNormalizer;
use App\Service\OneRecordParser;
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

    public function __construct(EntityManagerInterface $entityManager,SerializerInterface $serializer, OrNormalizer $normalizer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
    }

    #[Route('/fixevent', name: 'fixevent', methods: ['GET'])]
    public function fixevent(): JsonResponse
    {
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


        $shipment = new Shipment();
        $shipment->setGoodsDescription('GoodsDescription');
        $gr_weight = new Value();
        $gr_weight->setNumericalValue(1.5);
        $gr_weight->setUnit(MeasurementUnitCode::KGM);
        $shipment->setTotalGrossWeight($gr_weight);
        $shipment->addPieces($piece);
        dump($shipment);die;
        return $this->json($dimension);
    }

    /**
     * GET /logistics-objects/{logisticsObjectId}
     */
    #[Route('/logistic-objects/{logisticsObjectId}', name: 'one_record_get_logistics_object', methods: ['GET'])]
    public function getLogisticsObject(string $logisticsObjectId): JsonResponse
    {
        $object = $this->entityManager->getRepository(LogisticsObject::class)->find($logisticsObjectId);

        if (!$object) {
            return $this->json(['error' => 'Logistics Object not found'], 404);
        }
        $serializer = new Serializer([$this->normalizer], [new JsonEncoder()]);
        $jsonData = $serializer->serialize($object,'json');

        return new JsonResponse($jsonData, 200, ['Content-Type' => 'application/ld+json'], true);
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
//    /**
//     * 🔹 GET, POST /logistics-objects/{logisticsObjectId}/logistics-events
//     * Получение/Создание событий
//     */
//    #[Route('/{logisticsObjectId}/logistics-events', name: 'logistics_events', methods: ['GET', 'POST'])]
//    public function logisticsEvents(Request $request, string $logisticsObjectId): JsonResponse
//    {
//        if ($request->isMethod('POST')) {
//            $data = json_decode($request->getContent(), true);
//
//            if (!$data) {
//                return $this->json(['error' => 'Invalid JSON'], 400);
//            }
//
//            $event = new LogisticsEvent();
//            $event->setEventType($data['eventType'] ?? 'Unknown');
//            $event->setLogisticsObject($logisticsObjectId);
//
//            $this->entityManager->persist($event);
//            $this->entityManager->flush();
//
//            return $this->json($event, 201);
//        }
//
//        return $this->json(['message' => 'Logistics Events for Logistics Object ' . $logisticsObjectId]);
//    }
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
