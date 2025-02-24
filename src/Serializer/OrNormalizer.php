<?php

namespace App\Serializer;

use App\Entity\Cargo\Abstract\LogisticsObject;
use App\Entity\Cargo\Agent\Organization;
use App\Entity\Cargo\Agent\Person;
use ReflectionClass;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class OrNormalizer  implements NormalizerInterface, DenormalizerInterface
{
    private ObjectNormalizer $normalizer;
    private PropertyAccessor $propertyAccessor;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
        $this->propertyAccessor = new PropertyAccessor();
    }
    private function findProp(ReflectionClass $reflect, string $propertyName): ?object
    {
        $props = $reflect->getProperties();
        foreach ($props as $prop) {
            if ($prop->getName() === $propertyName) {
                return $prop;
            }
        }
        if(!empty($reflect->getParentClass())){
            return $this->findProp($reflect->getParentClass(), $propertyName);
        }
        return null;
    }
    public function normalize_old($object, ?string $format = null, array $context = [], $core = 1): array
    {
//        $context[AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER] = function ($object) {
//            return $object->getId(); // Можно вернуть любой уникальный идентификатор объекта
//        };
        $context[AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER] = function ($object) {
            return method_exists($object, 'getId') ? $object->getId() : spl_object_id($object);
        };
        $data = $this->normalizer->normalize($object, $format, $context);
//        dump($data);die;
        $class_full_name = explode('\\',get_class($object));
        if(in_array('Cargo', $class_full_name) || in_array('CoreCodeLists', $class_full_name)){
            $context_pref = 'cargo';
        } else {
            dump($class_full_name);die;
        }
        if($core){
            $resp['@context'][$context_pref] = "https://onerecord.iata.org/ns/cargo#";
        }


        $resp['@type'] = [$context_pref.':'.end($class_full_name)];
        $all_classes = get_declared_classes();
        foreach ($all_classes as $class) {
            if(is_subclass_of($object, $class)){
                $class_full_name = explode('\\',$class);
                $resp['@type'][] = $context_pref.':'.end($class_full_name);
            }
        }
        $reflect = new ReflectionClass(get_class($object));

        if(isset($data)){
            foreach ($data as $index => $datum) {
                $prop = $this->findProp($reflect, $index);
//                if($index == 'jobTitle'){
//                    dump($prop);die;
//                }
//
//                if (empty($prop)) {
//                    dump($prop, $reflect, $index);
//                    die;
//                }

                if (in_array($prop->getType()->getName(), ['string', 'float'])) {
                    if($index == 'numericalValue'){
                        $ntype = $prop->getType()->getName();
                        if($ntype == 'float'){
                            $ntype = 'http://www.w3.org/2001/XMLSchema#double';
                        }
                        $resp['cargo:' . $index] = [
                            '@type'=>$ntype,
                            '@value'=>$data[$index],
                        ];
                    } else {
                        $resp['cargo:' . $index] = $data[$index];
                    }
                } elseif ($prop->getType()->getName() == 'Doctrine\Common\Collections\Collection') {
                    $resp['cargo:' . $index] = [];
                    $collection = $prop->getValue($object);
                    foreach ($collection as $item) {
                        $resp['cargo:' . $index][] = $this->normalize($item, $format, $context, 0);
                    }
                } else {
//                dump($prop);
//                dump($object);die;
                    $pr_value = $prop->getValue($object);
                    if(!empty($pr_value)){
                        $resp['cargo:' . $index][] = $this->normalize($pr_value, $format, $context, 0);
                    }
//                if()

//                $resp['cargo:' . $index][] = 333;
//                dump($resp);
//                dump($prop->getValue($object), $index);
//                die;
                }
            }
        }

//        dump($resp);die;
        return $resp;
    }

    /**
     * 🔹 Преобразует объект в One Record JSON-LD формат при отправке (сокращенный формат)
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, 'jsonld', $context);
//        $data['ids'] = $object->getId();
        return $this->normalizeShortFormat($object, $data);
    }
    private function normalizeShortFormat($object, array $data): array
    {
        $oneRecordData = [
            '@context' => ['cargo' => 'https://onerecord.iata.org/ns/cargo#'],
            '@type' => 'cargo:' . $this->getOneRecordShortType($object),
            '@id' => $data['@id'] ?? $this->generateOneRecordId($object),
        ];

        foreach ($data as $property => $value) {
            if(!empty($value) && $property != 'id'){
                $oneRecordProperty = 'cargo:' . $property;
                $oneRecordData[$oneRecordProperty] = $value;
            }
        }

        return $oneRecordData;
    }
    private function getOneRecordShortType($object): string
    {
        return (new ReflectionClass($object))->getShortName();
    }

    private function generateOneRecordId($object): string
    {
//        return 'https://example.com/' . strtolower((new ReflectionClass($object))->getShortName()) . '/' . $this->propertyAccessor->getValue($object, 'id');
        return 'https://ordub.awery.com.ua/logistic-objects/' . $this->propertyAccessor->getValue($object, 'id');
    }
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {

        // API Platform должен игнорировать этот нормалайзер
        if (isset($context['request_uri']) && str_starts_with($context['request_uri'], '/api/')) {
            return false;
        }

        // Нормализуем только объекты, а не строки
        return is_object($data) && $data instanceof LogisticsObject;
    }


    public function getSupportedTypes(?string $format): array
    {
        return [
            LogisticsObject::class => true,
            Person::class  => true,
            Organization::class  => true,
        ];
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        // TODO: Implement denormalize() method.
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if (isset($context['request_uri']) && str_starts_with($context['request_uri'], '/api/')) {
            return false;
        }
        return true;
    }
}