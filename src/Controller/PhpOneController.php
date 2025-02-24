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
        $setting = $this->em->getRepository(Settings::class)->findBy(['id' => $request->get('id')]);
        if (!empty($setting)) {
            $setting->base_url = $request->get('base_url');
            $setting->token = $request->get('token');
            $setting->email = $request->get('email');
            $this->em->flush();
        }
        return new JsonResponse(['status' => 'success']);
    }
}