<?php
namespace App\Controller;

use App\Entity\Awb;
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
        $requestData = json_decode($request->getContent(), true);
        if (!empty($requestData['id'])) {
            $setting = $this->em->getRepository(Awb::class)->findBy(['id' => $requestData['id']]);
        } else {
            $setting = new Awb();
        }
        if (!empty($setting)) {
            foreach ($requestData as $key => $value) {
                $setting->{$key} = $value;
            }
            if (empty($requestData['id'])) {
                $this->em->persist($setting);
            }
            $this->em->flush();
        }
        return new JsonResponse(['status' => 'success']);
    }
}