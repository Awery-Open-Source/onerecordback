<?php
namespace App\Controller;

use App\Entity\Settings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PhpOneController extends AbstractController
{
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
//        $this->normalizer = $normalizer;
        $this->em = $em;
    }

    #[Route('/api/getSubs', name: 'api_get_subs', methods: ['GET'])]
    public function getSubs(Request $request):JsonResponse
    {
        return new JsonResponse($this->em->getRepository(Settings::class)->findAll());
    }

    #[Route('/api/updateSub', name: 'api_update_sub', methods: ['POST'])]
    public function updateSub(Request $request):JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        if (!empty($requestData['id'])) {
            $setting = $this->em->getRepository(Settings::class)->findBy(['id' => $requestData['id']]);
        } else {
            $setting = new Settings();
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