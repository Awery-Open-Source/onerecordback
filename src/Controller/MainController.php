<?php

namespace App\Controller;


use App\Entity\Cargo\Abstract\LogisticsObject;
use App\Entity\Cargo\Agent\Organization;
use App\Entity\Cargo\Agent\Person;
use App\Entity\Cargo\Agent\Actor;

use App\Entity\Cargo\Embedded\ContactDetail;
use App\Entity\Cargo\Embedded\Value;
use App\Entity\Cargo\Event\LogisticsEvent;


use App\Entity\CoreCodeLists\MeasurementUnitCode;
//use App\Serializer\OrNormalizer;
//use App\Service\OneRecordClass;
use App\Service\OneRecordParser;
//use App\Service\OntologyParser;
use Doctrine\ORM\EntityManagerInterface;
use EasyRdf\Graph;

use EasyRdf\RdfNamespace;
use Exception;
use Nette\PhpGenerator\ClassType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class MainController extends AbstractController
{
    private EntityManagerInterface $em;


    public function __construct(EntityManagerInterface $em,SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
//        $this->normalizer = $normalizer;
        $this->em = $em;
    }

    #[Route('/main2', name: 'app_main2')]
    public function index2(): Response {
        $value = new Value();
        $value->setNumericalValue(2);
        $value->setUnit(MeasurementUnitCode::GLL);
        $this->em->persist($value);
        $this->em->flush();
        dump($value);die;
                $org = new Organization();
        $org->setName('Long org name');
        $org->setShortName('org_name');
                $org_p = new Organization();
        $org_p->setName('Long Parent_org name');
        $org_p->setShortName('parent_org_name');
        $this->em->persist($org);
//        $this->em->persist($org_p);
//        $org->setParentOrganization($org_p);
        $person = new Person();
        $person->setFirstName('First');
        $person->setLastName('LastName');

        $person->setSkeletonIndicator(1);
        $person->setAssociatedOrganization($org);
        $this->em->persist($person);
        $cd1 = new ContactDetail();
        $cd1->setTextualValue('first detail');
        $this->em->persist($cd1);
        $cd2 = new ContactDetail();
        $cd2->setTextualValue('second detail');
        $this->em->persist($cd2);
//        $person->addContactDetail($cd1);
//        $person->addContactDetail($cd2);
        $person->setSkeletonIndicator(1);
//        dump($person);die;
//        $act = new Actor();
//        $act->setFirstName('John');
//        $act->setSkeletonIndicator(1);
//        $this->em->persist($act);
        $this->em->flush();
        dump($person);
        $serializer = new Serializer([$this->normalizer], [new JsonEncoder()]);
//        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
//        dump($person);die;
        $onerecord_data = $serializer->serialize($org, 'json');
//        dump($onerecord_data);die;
//        $uuid = Uuid::v1();
//        dump($uuid->toString());die;
        return $this->json(json_decode($onerecord_data));
    }
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/generate', name: 'app_generate')]
    public function generate(): Response {
//        $ex = new ExternalReference();
//        dump($ex);die;
//        $lo = $this->em->getRepository(LogisticsObject::class)->find('0194ff9f-f4ae-7748-b012-e384a9c7ea9a');
//        dump($lo);die;
//        $org1 = new Organization();
//        $act = new Actor();
//
//        $org1->setName('org_1');
//        $this->em->persist($org1);
//        $org2 = new Organization();
//        $org2->setName('org_2');
//        $this->em->persist($org2);
//        $this->em->flush();
//
//        $check = new Check();
//        $org1->addChecks($check);
//        $org1->setParentOrganization($org2);
//        $org1->addContactPersons($act);
//        $this->em->flush();
//        dump($org1);die;
        $projectDir = $this->getParameter('kernel.project_dir');
        $orp = new OneRecordParser($projectDir, '/src/Entity/','App\Entity\\');
        $orp->coreCodeLists();
        $orp->cargo();
//        $orp->api();
//        $this->copyFolder($projectDir.'/src/Entity/', '/var/www/one-record/src/Entity/');
//        $this->copyFolder($projectDir.'/src/Attribute/', '/var/www/one-record/src/Attribute/');
        return $this->json(['success' => true]);
    }

    private function copyFolder($source, $destination) {
        if (!is_dir($source)) {
            return false;
        }
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $srcFile = rtrim($source, '/') . '/' . $file;
            $destFile = rtrim($destination, '/') . '/' . $file;

            if (is_dir($srcFile)) {
                $this->copyFolder($srcFile, $destFile);
            } else {
                copy($srcFile, $destFile);
            }
        }
        return true;
    }

}
