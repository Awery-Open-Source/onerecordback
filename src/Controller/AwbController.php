<?php
namespace App\Controller;

use App\Entity\Awb;
use App\Entity\Piece;
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
        return new JsonResponse($this->em->getRepository(Piece::class)->findAll());
    }

    protected function updatePiece($piece)
    {
        if (!empty($piece['id'])) {
            $Piece = $this->em->getRepository(Piece::class)->find($piece['id']);
        } else {
            $Piece = new Piece();
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
}