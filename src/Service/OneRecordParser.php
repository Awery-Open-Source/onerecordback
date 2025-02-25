<?php

namespace App\Service;

use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;

class OneRecordParser
{
    private array $classes;
    private array $enums;
    private string $folder_path;
    private string $namespace;
    private string $project_dir;
    private string $version;

    public function __construct(string $project_dir, string $folder_path, string $namespace)
    {
        $this->project_dir = $project_dir;
        $this->folder_path = $this->project_dir . $folder_path;
        $this->namespace = $namespace;
    }


    public function coreCodeLists()
    {
//        $path = 'https://onerecord.iata.org/ns/coreCodeLists/ontology.jsonld';
        $path = 'https://onerecord.iata.org/ns/code-lists/ontology.jsonld';
        $enum_raw_list = $this->getList($path);
//        dump($enum_raw_list);
//        die;
        $enum_classes = $this->classList($enum_raw_list);

        foreach ($enum_classes as $item) {
            $this->createClassNew($item, 1);
        }
        return $enum_classes;
    }

    public function cargo(): void
    {
        $path = 'https://onerecord.iata.org/ns/cargo/ontology.jsonld';
        $cargo_raw_list = $this->getList($path);
        $this->classes = $this->classList($cargo_raw_list);
        $properties = $this->getProperties($cargo_raw_list);
        $this->mapPropertiesToClass($properties, $cargo_raw_list);
//        dump($cargo_raw_list['https://onerecord.iata.org/ns/cargo#ActionTimeType']);
//        dump($cargo_raw_list['https://onerecord.iata.org/ns/cargo#actionTimeType']);die;
//        dump($cargo_raw_list);die;
//        unset($this->classes['https://onerecord.iata.org/ns/cargo#BookingShipment']['properties']['https://onerecord.iata.org/ns/cargo#densityGroupCode']);
//        $this->classes['https://onerecord.iata.org/ns/cargo#LogisticsObject']['properties']['https://onerecord.iata.org/ns/cargo#externalReferences']['relation'] = 'ManyToMany';
        $this->enums = [];
        foreach ($this->classes as $class) {
            if($class['sub_category']=='Enum'){
                $this->enums[] = $class['@id'];
//                dump($class);
                $this->createClassNew($class ,1);
            }
        }
//        dump($this->enums);die;
//        die;
        foreach ($this->classes as $class) {
            if (!str_contains($class['@id'], 'ns/code-lists')) {
//                dump($class);
                $this->createClassNew($class);
            }
//            if($class['sub_category']=='Enum'){
//                dump($class);
//                $this->createClassNew($class ,1);
//            }
        }
//        die;

        die;
//        LogisticsEvent
    }
    public function api(): void
    {
        $path = 'https://onerecord.iata.org/ns/api/ontology.jsonld';
        $api_raw_list = $this->getList($path);
        $this->classes = $this->classList($api_raw_list);
//        dump($api_raw_list);die;
        $properties = $this->getProperties($api_raw_list);
        $this->mapPropertiesToClass($properties, $api_raw_list);
//        dump($this->classes);die;
//        $this->classes['https://onerecord.iata.org/ns/cargo#LogisticsObject']['properties']['https://onerecord.iata.org/ns/cargo#externalReferences']['relation'] = 'ManyToMany';
        foreach ($this->classes as $class) {
            if (!empty($class['properties'])) {
                $class['sub_category'] = '';
                foreach ($class['properties'] as &$property) {
                    $property['maxCardinality'] = 1;
                }
                $this->createClassNew($class);
            }
        }
    }

    private function getList($file_path)
    {
        $jsonContent = file_get_contents($file_path, false, stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]));
        $json = json_decode($jsonContent, true);
        $list = array_column($json, null, '@id');
//        dump($list);die;
        if (!empty($list['https://onerecord.iata.org/ns/coreCodeLists'])) {
            $version = $list['https://onerecord.iata.org/ns/coreCodeLists']['http://www.w3.org/2002/07/owl#versionInfo'][0]['@value'];
            $file_name = 'coreCodeLists_' . $version . '.jsonld';
        } elseif (!empty($list['https://onerecord.iata.org/ns/code-lists'])) {
            $version = $list['https://onerecord.iata.org/ns/code-lists']['http://www.w3.org/2002/07/owl#versionInfo'][0]['@value'];
            $file_name = 'code-lists_' . $version . '.jsonld';
        } elseif (!empty($list['https://onerecord.iata.org/ns/cargo'])) {
            $version = $list['https://onerecord.iata.org/ns/cargo']['http://www.w3.org/2002/07/owl#versionInfo'][0]['@value'];
            $file_name = 'cargo_' . $version . '.jsonld';
        } elseif (!empty($list['https://onerecord.iata.org/ns/api'])) {
            $version = $list['https://onerecord.iata.org/ns/api']['http://www.w3.org/2002/07/owl#versionInfo'][0]['@value'];
            $file_name = 'api_' . $version . '.jsonld';
        } else {
            dump('Version not found');
            die;
        }
        $this->version = $version;
        file_put_contents($this->project_dir . '/' . $file_name, $jsonContent);
        $uniq_list = $this->removeEquivalentClass($list);
        return $this->flatList($uniq_list);
    }

    private function removeEquivalentClass($list)
    {
        foreach ($list as &$item) {
            if (!empty($item['http://www.w3.org/2002/07/owl#equivalentClass'])) {
                $equivalentId = $item['http://www.w3.org/2002/07/owl#equivalentClass'][0]['@id'] ?? null;
                if ($equivalentId && isset($list[$equivalentId])) {
                    $equivalentData = $list[$equivalentId];
                    $list[$item['@id']] = array_merge($equivalentData, $item);
                    unset($list[$item['@id']]['http://www.w3.org/2002/07/owl#equivalentClass']);
                    unset($list[$equivalentId]);
                }
            }
        }
        return $list;
    }

    private function flatList($list)
    {
        foreach ($list as &$item) {
            if (!empty($item['@type'])) {
                $item['type'] = substr($item['@type'][0], strrpos($item['@type'][0], '#') + 1);
                unset($item['@type']);
            }
            if (!empty($item['http://www.w3.org/2002/07/owl#oneOf'])) {
                $item['oneOf'] = array_column($item['http://www.w3.org/2002/07/owl#oneOf'][0]['@list'], '@id');
                unset($item['http://www.w3.org/2002/07/owl#oneOf']);
            }
            if (!empty($item['http://www.w3.org/2000/01/rdf-schema#comment'])) {
                $item['comments'] = array_column($item['http://www.w3.org/2000/01/rdf-schema#comment'], '@value');
                unset($item['http://www.w3.org/2000/01/rdf-schema#comment']);
            }
            if (!empty($item['http://www.w3.org/2000/01/rdf-schema#label'])) {
                $item['label'] = $item['http://www.w3.org/2000/01/rdf-schema#label'][0]['@value'];
                unset($item['http://www.w3.org/2000/01/rdf-schema#label']);
            }
        }
        return $list;
    }


    private function addClassObjectProperty($property, \Nette\PhpGenerator\ClassType $class)
    {
        $prop_class = $this->classes[$property['phpType']];
        $prop_class_path = $prop_class['namespace'] . '\\' . $prop_class['label'];
        $comments = $property['comments'];
        $comments[] = '';
        $comments[] = '@link ' . $property['id'] . ' Ontology';
//        $comments[] = '@link ' . $prop_class['@id'] . ' Property';
        $comment = implode(PHP_EOL, $comments);
        $column_prop = [];
        $codelist = false;
        if (str_contains($property['phpType'], 'ns/code-lists')) {
            $prop_class_path = '\App\Entity\CoreCodeLists\\' . basename($property['phpType']);
            $codelist = true;
        }
        $enum = false;
        if (in_array($property['phpType'],$this->enums)) {
//            $prop_class_path = '\App\Entity\Cargo\Enum\\' . basename($property['phpType']);
            $prop_class_path = '\App\Entity\Cargo\Enum\\' . substr($property['phpType'], strrpos($property['phpType'], '#') + 1);;

            $codelist = true;
            $enum = true;
        }
        if ($class->getName() !== $prop_class['label']) {
            $class->getNamespace()->addUse($prop_class_path);
        }
        $prop_args = [
            'targetEntity' => new Literal($prop_class['label'] . '::class')
        ];
        if (!empty($property['mappedBy'])) {
            if ($property['mappedBy'] == 'subOrganization') {
                $property['mappedBy'] = 'parentOrganization';
            }
            if ($property['mappedBy'] == 'subLocations') {
                $property['mappedBy'] = 'subLocationOf';
            }
            $prop_args['mappedBy'] = $property['mappedBy'];
        }
        if (!empty($property['inversedBy'])) {
            $prop_args['inversedBy'] = $property['inversedBy'];
        }

        if (!empty($property['maxCardinality'])) {
            $prop = $class->addProperty($property['label'])
                ->setType('?' . $prop_class_path)
                ->setValue(null)
                ->setProtected()
                ->addComment($comment);
            if ($codelist) {
                $column_prop['type'] = 'string';
                $column_prop['nullable'] = true;
                if($enum){
                    $ett = substr($property['phpType'], strrpos($property['phpType'], '#') + 1);
                    $column_prop['enumType'] = new Literal($ett. '::class');
                } else {
                    $column_prop['enumType'] = new Literal(basename($property['phpType']) . '::class');
                }

                $prop->addAttribute('Doctrine\ORM\Mapping\Column', $column_prop);
            } else {
                $prop->addAttribute('Doctrine\ORM\Mapping\\' . $property['relation'], $prop_args);
                //add pattern and max_lengh
            }

            $class->addMethod('get' . ucfirst($property['label']))
                ->addComment('@return ' . basename($prop_class['label'] . '|null'))
                ->setReturnType('?' . $prop_class_path)
                ->setBody('return $this->' . $property['label'] . ';');

            $class->addMethod('set' . ucfirst($property['label']))
                ->addComment('@param ' . basename($prop_class['label']) . '|null $' . $property['label'])
                ->addComment('@return static')
                ->setReturnType('static')
                ->addBody('$this->' . $property['label'] . ' = $' . $property['label'] . ';')
                ->addBody('return $this;')
                ->addParameter($property['label'])->setType('?' . $prop_class_path);
        } else {
            if ($property['relation'] == 'OneToMany') {
                if ($class->getName() == 'LogisticsObject' && $property['label'] == 'externalReferences') {
                    $property['relation'] = 'ManyToMany';
                }
                $class->getNamespace()->addUse('\Doctrine\Common\Collections\ArrayCollection');
                $class->getNamespace()->addUse('\Doctrine\Common\Collections\Collection');
                $prop = $class->addProperty($property['label'])
                    ->setType('\Doctrine\Common\Collections\Collection')
                    ->setProtected()
                    ->addComment($comment);
                try {
                    $construct = $class->getMethod('__construct');
                } catch (\Exception $e) {
                    $construct = $class->addMethod('__construct');
                }

                $construct->addBody('$this->' . $property['label'] . ' = new ArrayCollection();');
                $prop_args['cascade'] = ['persist', 'remove'];
//                $prop_args['fetch'] = 'EAGER';
                $prop->addAttribute('Doctrine\ORM\Mapping\\' . $property['relation'], $prop_args);

                $class->addMethod('get' . ucfirst($property['label']))
                    ->addComment('@return Collection <int, ' . $prop_class['label'] . '>')
                    ->setReturnType('\Doctrine\Common\Collections\Collection')
                    ->setBody('return $this->' . $property['label'] . ';');

                $class->addMethod('add' . ucfirst($property['label']))
                    ->addComment('@param ' . $prop_class['label'] . ' $' . lcfirst($prop_class['label']))
                    ->addComment('@return static')
                    ->setReturnType('static')
                    ->addBody('if (!$this->' . $property['label'] . '->contains($' . lcfirst($prop_class['label']) . ')) {')
                    ->addBody(chr(9) . '$this->' . $property['label'] . '->add($' . lcfirst($prop_class['label']) . ');')
                    ->addBody(chr(9) . '$' . lcfirst($prop_class['label']) . '->set' . ucfirst($property['mappedBy']) . '($this);')
                    ->addBody('}')
                    ->addBody('return $this;')
                    ->addParameter(lcfirst($prop_class['label']))->setType($prop_class_path);

                $class->addMethod('remove' . ucfirst($property['label']))
                    ->addComment('@param ' . $prop_class['label'] . ' $' . lcfirst($prop_class['label']))
                    ->addComment('@return static')
                    ->setReturnType('static')
                    ->addBody('if ($this->' . $property['label'] . '->removeElement($' . lcfirst($prop_class['label']) . ')) {')
                    ->addBody(chr(9) . 'if ($' . lcfirst($prop_class['label']) . '->get' . ucfirst($property['mappedBy']) . '() === $this ) {')
                    ->addBody(chr(9) . chr(9) . '$' . lcfirst($prop_class['label']) . '->set' . ucfirst($property['mappedBy']) . '(null);')
                    ->addBody(chr(9) . '}')
                    ->addBody('}')
                    ->addBody('return $this;')
                    ->addParameter(lcfirst($prop_class['label']))->setType($prop_class_path);
            } else {
                //ManyToMany
                $class->getNamespace()->addUse('\Doctrine\Common\Collections\ArrayCollection');
                $class->getNamespace()->addUse('\Doctrine\Common\Collections\Collection');
                if (str_contains($property['phpType'], 'ns/code-lists')) {
                    $class->addProperty($property['label'])
                        ->setType('array')
                        ->setValue([])
                        ->setProtected()
                        ->addComment($comment)
                        ->addAttribute('Doctrine\ORM\Mapping\Column', ['type' => 'json', 'nullable' => true]);
                    $class->getNamespace()->addUse($prop_class_path);
                    $class->addMethod('get' . ucfirst($property['label']))
                        ->setReturnType('?array')

                        ->addComment('@return ' . basename($prop_class['label']) . '[]|null')
                        ->setBody('return array_map(fn($value) => ' . basename($prop_class['label']) . '::tryFrom($value), $this->' . $property['label'] . ');');
                    $class->addMethod('set' . ucfirst($property['label']))
                        ->setReturnType('static')
                        ->addComment('@param ' . basename($prop_class['label']) . '[] $' . $property['label'])
                        ->addBody('$this->' . $property['label'] . ' = array_map(fn(' . basename($prop_class['label']) . ' $code) => $code->value, $' . lcfirst($property['label']) . ');')
                        ->addBody('return $this;')
                        ->addParameter(lcfirst($property['label']))->setType('array');

                    $class->addMethod('add' . ucfirst(basename($prop_class['label'])))
                        ->addComment('@param ' . basename($prop_class['label']) . ' $' . lcfirst(basename($prop_class['label'])))
                        ->addComment('@return static')
                        ->setReturnType('static')
                        ->addBody('if (!in_array($' . lcfirst(basename($prop_class['label'])) . '->value, $this->' . $property['label'] . ', true)) {')
                        ->addBody(chr(9) . '$this->' . $property['label'] . '[] = $' . lcfirst(basename($prop_class['label'])) . '->value;')
                        ->addBody('}')
                        ->addBody('return $this;')
                        ->addParameter(lcfirst(basename($prop_class['label'])))->setType($prop_class_path);

                    $class->addMethod('remove' . ucfirst($property['label']))
                        ->addComment('@param ' . basename($prop_class['label']) . ' $' . lcfirst(basename($prop_class['label'])))
                        ->addComment('@return static')
                        ->setReturnType('static')
                        ->addBody('$this->' . $property['label'] . ' = array_filter(')
                        ->addBody(chr(9) . '$this->' . $property['label'] . ',')
                        ->addBody(chr(9) . 'fn($value) => $value !== $' . lcfirst(basename($prop_class['label'])) . '->value')
                        ->addBody(');')
                        ->addBody('return $this;')
                        ->addParameter(lcfirst(basename($prop_class['label'])))->setType($prop_class_path);
                    try {
                        $construct = $class->getMethod('__construct');
                    } catch (\Exception $e) {
                        $construct = $class->addMethod('__construct');
                    }

                    $construct->addBody('$this->' . $property['label'] . ' = [];');
                    return;
                }
                $prop = $class->addProperty($property['label'])
                    ->setType('\Doctrine\Common\Collections\Collection')
                    ->setProtected()
                    ->addComment($comment);
                $prop->addAttribute('Doctrine\ORM\Mapping\\' . $property['relation'], $prop_args);
                //Kostilik
                if ($property['joinTable'] == 'bookingpreferences_location') {
                    if (str_contains($property['label'], 'excluded')) {
                        $property['joinTable'] = 'bookingpreferences_location_excluded';
                    } elseif (str_contains($property['label'], 'included')) {
                        $property['joinTable'] = 'bookingpreferences_location_included';
                    }
                }
                if ($property['joinTable'] == 'securitydeclaration_regulatedentity') {
                    if (str_contains($property['label'], 'other')) {
                        $property['joinTable'] = 'securitydeclaration_regulatedentity_other';
                    } elseif (str_contains($property['label'], 'Acceptor')) {
                        $property['joinTable'] = 'securitydeclaration_regulatedentity_acceptor';
                    }
                }
                //Kostilik end
                $prop->addAttribute('Doctrine\ORM\Mapping\JoinTable', [
                    'name' => $property['joinTable'],
                    'joinColumns' => [
                        new Literal('new ORM\JoinColumn(name: \'' . $property['joinColumns'] . '\', referencedColumnName: \'id\', onDelete: \'CASCADE\')')
                    ],
                    'inverseJoinColumns' => [
                        new Literal('new ORM\JoinColumn(name: \'' . $property['inverseJoinColumns'] . '\', referencedColumnName: \'id\', onDelete: \'CASCADE\')')
                    ]
                ]);
//                $prop->addAttribute('Doctrine\ORM\Mapping\JoinColumn', [
//                    'name' => $property['joinColumns'],
//                    'referencedColumnName' => 'id',
//                    'onDelete' => 'CASCADE',
//                ]);
//                $prop->addAttribute('Doctrine\ORM\Mapping\InverseJoinColumn', [
//                    'name' => $property['inverseJoinColumns'],
//                    'referencedColumnName' => 'id',
//                    'onDelete' => 'CASCADE',
//                ]);
                try {
                    $construct = $class->getMethod('__construct');
                } catch (\Exception $e) {
                    $construct = $class->addMethod('__construct');
                }
                $construct->addBody('$this->' . $property['label'] . ' = new ArrayCollection();');
                $class->addMethod('get' . ucfirst($property['label']))
                    ->addComment('@return Collection <int, ' . $prop_class['label'] . '>')
                    ->setReturnType('\Doctrine\Common\Collections\Collection')
                    ->setBody('return $this->' . $property['label'] . ';');

                $class->addMethod('add' . ucfirst($property['label']))
                    ->addComment('@param ' . $prop_class['label'] . ' $' . lcfirst($prop_class['label']))
                    ->addComment('@return static')
                    ->setReturnType('static')
                    ->addBody('if (!$this->' . $property['label'] . '->contains($' . lcfirst($prop_class['label']) . ')) {')
                    ->addBody(chr(9) . '$this->' . $property['label'] . '->add($' . lcfirst($prop_class['label']) . ');')
                    ->addBody('}')
                    ->addBody('return $this;')
                    ->addParameter(lcfirst($prop_class['label']))->setType($prop_class_path);

                $class->addMethod('remove' . ucfirst($property['label']))
                    ->addComment('@param ' . $prop_class['label'] . ' $' . lcfirst($prop_class['label']))
                    ->addComment('@return static')
                    ->setReturnType('static')
                    ->addBody('$this->' . $property['label'] . '->removeElement($' . lcfirst($prop_class['label']) . ');')
                    ->addBody('return $this;')
                    ->addParameter(lcfirst($prop_class['label']))->setType($prop_class_path);
            }
        }
    }

    private function addClassProperty($property, $class)
    {
        $comments = $property['comments'];
        $comments[] = '';
        $comments[] = '@link ' . $property['id'] . ' Ontology';
        $comment = implode(PHP_EOL, $comments);

        if (!empty($property['maxCardinality'])) {
            $class->addProperty($property['label'])
                ->setType('?' . $property['phpType'])
                ->setValue(null)
                ->setProtected()
                ->addComment($comment)
                ->addAttribute('Doctrine\ORM\Mapping\Column', ['nullable' => true]);
            $class->addMethod('get' . ucfirst($property['label']))
                ->setReturnType('?' . $property['phpType'])
                ->setBody('return $this->' . $property['label'] . ';');
            $class->addMethod('set' . ucfirst($property['label']))
                ->addComment('@param ' . $property['phpType'] . '|null $' . $property['label'])
                ->addComment('@return static')
                ->setReturnType('static')
                ->addBody('$this->' . $property['label'] . ' = $' . $property['label'] . ';')
                ->addBody('return $this;')
                ->addParameter($property['label'])->setType('?' . $property['phpType']);
        } elseif ($property['phpType'] == 'json') {
            $class->addProperty($property['label'])
                ->setType('?array')
                ->setValue([])
                ->setProtected()
                ->addComment($comment)
                ->addAttribute('Doctrine\ORM\Mapping\Column', ['type' => 'json', 'nullable' => true]);
            $class->addMethod('get' . ucfirst($property['label']))
                ->setReturnType('?array')
                ->setBody('return $this->' . $property['label'] . ';');
            $class->addMethod('set' . ucfirst($property['label']))
//                ->addComment('@param ' . $property['phpType'] . '|null $' . $property['label'])//array
                ->addComment('@return static')
                ->setReturnType('static')
                ->addBody('$this->' . $property['label'] . ' = $' . $property['label'] . ';')
                ->addBody('return $this;')
                ->addParameter($property['label'])->setType('?array');
        } else {
            dump($property, $class);
            die;
        }
    }

    private function _createClass($item, $namespace)
    {
        $class = $namespace->addClass($item['label']);
        $namespace->addUse('Doctrine\ORM\Mapping', 'ORM');
        $namespace->addUse('ApiPlatform\Metadata\ApiResource');
        $class->addAttribute('Doctrine\ORM\Mapping\Entity');
        $class->addAttribute('ApiPlatform\Metadata\ApiResource');
//        $class->addAttribute('ApiPlatform\Metadata\ApiResource',[
//            'uriTemplate'=>'/'.strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $item['label'])).'/{id}'
//        ]);
        if ($item['label'] == 'Check') {
            $class->addAttribute('Doctrine\ORM\Mapping\Table', ['name' => 'check_action']);
        }
        if ($item['sub_category'] == 'Abstract') {
            $class->setAbstract();
        }
        if (!empty($item['extends'])) {
            $ext_class = $this->classes[$item['extends']];
            $namespace->addUse($ext_class['namespace'] . '\\' . $ext_class['label']);
            $class->setExtends($ext_class['namespace'] . '\\' . $ext_class['label']);
            $construct = $class->addMethod('__construct');
            $construct->addBody('parent::__construct();');
        } else {
            if (!empty($item['have_children'])) {
                $class->addAttribute('Doctrine\ORM\Mapping\InheritanceType', ['JOINED']);
                $class->addAttribute('Doctrine\ORM\Mapping\DiscriminatorColumn', [
                    'name' => 'type',
                    'type' => 'string',
                    'length' => 25,
                ]);
            }
            $class->addProperty('id')
                ->setType('?string')
                ->setProtected()
                ->addAttribute('Doctrine\ORM\Mapping\Id')
                ->addAttribute('Doctrine\ORM\Mapping\GeneratedValue', [
                    'strategy' => 'NONE'
                ])
                ->addAttribute('Doctrine\ORM\Mapping\Column', [
                    'type' => 'string',
                    'length' => 36,
                    'unique' => true,
                ]);
            $namespace->addUse('Symfony\Component\Uid\Uuid');
            $construct = $class->addMethod('__construct');
            $construct->addBody('$this->id = $this->generateUuid();');
            $class->addMethod('getId')
                ->setReturnType('?string')
                ->setBody('return $this->id;');
            $class->addMethod('generateUuid')
                ->setReturnType('?string')
                ->setBody('$uuid = Uuid::v7();' . PHP_EOL . 'return $uuid->toString();');
        }
        if ($item['sub_category'] == 'Enum') {
//            $enum_item = $item;
//            $enum_item['label'] .= 'Enum';
//            $enum_item['namespace'] .= '\Enum';
//            $enum_item['path'] .= 'Enum/';
            $this->createClassNew($item, 1);
//            dump($item);die;
//            $namespace->addUse($enum_item['namespace'] . '\\' . $enum_item['label']);
//            try {
//                $construct = $class->getMethod('__construct');
//            } catch (\Exception $e) {
//                $construct = $class->addMethod('__construct')
//                    ->addParameter('code')->setType($enum_item['namespace'] . '\\' . $enum_item['label']);
//            }
//            $construct->addBody('$this->code = $code->value;')
//                ->addParameter('code')->setType($enum_item['namespace'] . '\\' . $enum_item['label']);
//            $column_prop['type'] = 'string';
//            $column_prop['nullable'] = true;
//            $column_prop['enumType'] = new Literal(basename($item['label']) . '::class');
//            $prop->addAttribute('Doctrine\ORM\Mapping\Column', $column_prop);

        }

        if (!empty($item['properties'])) {
            foreach ($item['properties'] as $property) {
                if ($property['type'] == 'object') {
                    $this->addClassObjectProperty($property, $class);
                } else {
                    $this->addClassProperty($property, $class);
                }
            }
        }
        return $class;
    }

    private function _createEnum($item, $namespace, &$comments)
    {
//        dump($item);
        $class = $namespace->addEnum($item['label']);
        $class->setType('string');
        $comments[] = '';
        $comments[] = 'Options:';
        foreach ($item['cases'] as $k => $value) {
//            dump($value);
            $comments[] = ($k + 1) . '. ' . ($value['label']) . ' – ' . $value['comment'] ?? '';
            $case_comment = $value['comment'] . PHP_EOL . PHP_EOL . '@link ' . $value['@id'] . ' Ontology';
            $case_name = iconv('UTF-8', 'ASCII//TRANSLIT', $value['label']);
            switch ($case_name) {
                case 0:
                    $case_name = 'ZERO';
                    break;
                case 1:
                    $case_name = 'ONE';
                    break;
                case 2:
                    $case_name = 'TWO';
                    break;
                case 3:
                    $case_name = 'THREE';
                    break;
                case 4:
                    $case_name = 'FOUR';
                    break;
                case 5:
                    $case_name = 'FIVE';
                    break;
                case 6:
                    $case_name = 'SIX';
                    break;
                case 7:
                    $case_name = 'SEVEN';
                    break;
                case 8:
                    $case_name = 'EIGHT';
                    break;
                case 9:
                    $case_name = 'NINE';
                    break;
                case 10:
                    $case_name = 'TEN';
                    break;
            }

            $class->addCase($case_name)->setValue($value['label'])->addComment($case_comment);
        }
        return $class;
    }

    private function createClassNew($item, $enum = false)
    {
        if(!empty($item['sub_category']) && $item['sub_category']=='Enum' && !$enum){
            return null;
        }
        $namespace = new PhpNamespace($item['namespace']);
        $file = new PhpFile;
        $file->addNamespace($namespace);
        $comments = $item['comments'];
        if ($enum) {
            $class = $this->_createEnum($item, $namespace, $comments);
        } else {
            $class = $this->_createClass($item, $namespace);
        }
        $namespace->addUse('App\Attribute\Version');
        $class->addAttribute('App\Attribute\Version', [$this->version]);
        $comments[] = '';
        $comments[] = '@link ' . $item['@id'] . ' Ontology';
        $comment = implode(PHP_EOL, $comments);
        $class->addComment($comment);
        if (!file_exists($item['path'])) {
            mkdir($item['path'], 0777, true);
        }
        file_put_contents($item['path'] . $item['label'] . '.php', $this->tabsToSpaces($file));
        return true;
    }

    private function tabsToSpaces(string $code, int $indentation = 4): string
    {
        return str_replace("\t", str_repeat(' ', $indentation), $code);
    }

    private function classList($list): array
    {
        $class_list = array_filter($list, function ($element) {
            return isset($element['type']) && $element['type'] === 'Class';
        });
        foreach ($class_list as &$item) {
            $item['label'] = substr($item['@id'], strrpos($item['@id'], '#') + 1);
            if ($item['label'] == 'CurrencyCode') {
                $this->setCurrencyCodeOneOf($item);
            }
            unset($item['oneOf']);
            if (empty($item['oneOf'])) {
                foreach ($list as $oneOf) {
                    if (!empty($oneOf['http://www.w3.org/1999/02/22-rdf-syntax-ns#type']) && in_array($item['@id'], array_column($oneOf['http://www.w3.org/1999/02/22-rdf-syntax-ns#type'], '@id'))) {
                        $item['cases'][] = $oneOf;
                    }
                }
            }
            if (!empty($item['cases'])) {
                foreach ($item['cases'] as &$oneOfItem) {
                    $oneOfItem['comment'] = $oneOfItem['comments'][0];
                    unset($oneOfItem['comments']);
                }
            }
            $item['category'] = '';
            if (preg_match('~/ns/([^#]+)#~', $item['@id'], $matches)) {
                $item['category'] = ucfirst($matches[1]);
            }
            if(empty($item['category']) && str_contains($item['@id'], 'https://onerecord.iata.org/ns/code-lists/')) {
                $item['category'] = 'CoreCodeLists';
                $item['label'] = basename($item['@id']);
                if ($item['label'] == 'CurrencyCode') {
                    $this->setCurrencyCodeOneOf($item);
                }
            }
            if (!empty($item['https://onerecord.iata.org/ns/cargo#vis_element'])) {
                $item['sub_category'] = $item['https://onerecord.iata.org/ns/cargo#vis_element'][0]['@value'];
            }

            $subClassOf = $item['http://www.w3.org/2000/01/rdf-schema#subClassOf'] ?? [];
            if (!empty($subClassOf) && isset($subClassOf[0]['@id'])) {
                $firstSubClass = $subClassOf[0]['@id'];
                if (isset($list[$firstSubClass]['type']) && $list[$firstSubClass]['type'] == 'Class') {
                    $item['extends'] = $firstSubClass;
                    $class_list[$firstSubClass]['have_children'] = 1;
                    array_shift($subClassOf);
                    $item['http://www.w3.org/2000/01/rdf-schema#subClassOf'] = $subClassOf;
                }
            }
            $item['path'] = $this->folder_path . $item['category'] . '/' . (!empty($item['sub_category']) ? $item['sub_category'] . '/' : '');
            $item['namespace'] = $this->namespace . $item['category'] . (!empty($item['sub_category']) ? '\\' . $item['sub_category'] : '');
        }
        return $class_list;
    }

    private function setCurrencyCodeOneOf(&$item): void
    {
        $url = 'https://www.six-group.com/dam/download/financial-information/data-center/iso-currrency/lists/list-one.xml';
        $item['comments'][] = 'List source -' . $url;
        $array = json_decode(json_encode(simplexml_load_string(file_get_contents($url))), true);
        $list = [];
        foreach ($array['CcyTbl']['CcyNtry'] as $cc) {
            if (!empty($cc['Ccy']) && empty($list[$cc['Ccy']])) {
                $list[$cc['Ccy']] = [
                    '@id' => $item['@id'] . '_' . $cc['Ccy'],
                    'type' => 'NamedIndividual',
//                    'comments' => [$cc['CcyNm']],
                    'comment' => $cc['CcyNm'],
                    'label' => $cc['Ccy'],
                ];
            }
        }
        $item['cases'] = array_values($list);
    }

    private function getProperties($cargo_raw_list)
    {
        foreach ($cargo_raw_list as $item) {
            // Проверка на ObjectProperty или DatatypeProperty
            if (isset($item['type']) && $item['type'] == 'ObjectProperty') {
                $type = 'object';
            } elseif (isset($item['type']) && $item['type'] == 'DatatypeProperty') {
                $type = 'datatype';
            } else {
                continue;
            }

            // Определение PHP типа данных через range
            $phpType = null;
            if (isset($item['http://www.w3.org/2000/01/rdf-schema#range'])) {
                $range = $item['http://www.w3.org/2000/01/rdf-schema#range'][0]['@id'] ?? null;
                $phpType = $this->mapRangeToPhpType($range, $type, $cargo_raw_list);
            }

            // Определение domain (классов, к которым относится свойство)
            $domain = [];
            if (isset($item['http://www.w3.org/2000/01/rdf-schema#domain'])) {
                $domain = array_column($item['http://www.w3.org/2000/01/rdf-schema#domain'], '@id');
            }

            // Инициализация параметров свойства
            $propertyId = $item['@id'];
            $properties[$propertyId] = [
                'id' => $propertyId,
                'type' => $type,
                'label' => substr($item['@id'], strrpos($item['@id'], '#') + 1),
                'comments' => $item['comments'] ?? (!empty($item['http://purl.org/dc/elements/1.1/description']) ? array_column($item['http://purl.org/dc/elements/1.1/description'], '@value') : []),
                //ttps://onerecord.iata.org/ns/cargo#inUnitComposition
                'phpType' => $phpType,
                'domain' => $domain,
                // Добавлено
                'maxCardinality' => null,
            ];
        }

        // Обработка maxCardinality
        foreach ($cargo_raw_list as $item) {
            if (isset($item['type']) && $item['type'] == 'Restriction') {
                $onProperty = $item['http://www.w3.org/2002/07/owl#onProperty'][0]['@id'] ?? null;
                $maxCardinality = $item['http://www.w3.org/2002/07/owl#maxCardinality'][0]['@value'] ?? null;

                if ($onProperty && isset($properties[$onProperty]) && $maxCardinality !== null) {
                    $properties[$onProperty]['maxCardinality'] = (int)$maxCardinality;
                }
            }
        }
        // Добавляем дополнительные параметры
        $properties = $this->addPatternsToProperties($properties, $cargo_raw_list);
        $properties = $this->addMaxLengthToProperties($properties, $cargo_raw_list);
        return $properties;
    }

    private function addMaxLengthToProperties(array $properties, array $data): array
    {
        foreach ($data as $item) {
            // Проверяем наличие ограничения withRestrictions
            if (!empty($item['http://www.w3.org/2002/07/owl#withRestrictions'])) {
                foreach ($item['http://www.w3.org/2002/07/owl#withRestrictions'] as $restrictionGroup) {
                    if (!empty($restrictionGroup['@list'])) {
                        foreach ($restrictionGroup['@list'] as $restriction) {
                            // Проверяем, существует ли ссылка на узел ограничения
                            if (!empty($restriction['@id']) && isset($data[$restriction['@id']])) {
                                $restrictionNode = $data[$restriction['@id']];
                                // Проверяем наличие maxLength
                                if (!empty($restrictionNode['http://www.w3.org/2001/XMLSchema#maxLength'])) {
                                    $maxLength = $restrictionNode['http://www.w3.org/2001/XMLSchema#maxLength'][0]['@value'] ?? null;

                                    // Определяем onProperty, связанный с ограничением
                                    foreach ($data as $property) {
                                        if (isset($property['http://www.w3.org/2000/01/rdf-schema#range'])) {
                                            foreach ($property['http://www.w3.org/2000/01/rdf-schema#range'] as $range) {
                                                if ($range['@id'] === $item['@id']) {
                                                    $onProperty = $property['@id'];
                                                    if ($onProperty && isset($properties[$onProperty]) && $maxLength !== null) {
                                                        $properties[$onProperty]['maxLength'] = (int)$maxLength;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $properties;
    }

    private function addPatternsToProperties(array $properties, array $data): array
    {
        foreach ($data as $item) {
            // Проверяем наличие ограничения withRestrictions
            if (!empty($item['http://www.w3.org/2002/07/owl#withRestrictions'])) {
                foreach ($item['http://www.w3.org/2002/07/owl#withRestrictions'] as $restrictionGroup) {
                    if (!empty($restrictionGroup['@list'])) {
                        foreach ($restrictionGroup['@list'] as $restriction) {
                            // Проверяем, существует ли ссылка на узел ограничения
                            if (!empty($restriction['@id']) && isset($data[$restriction['@id']])) {
                                $restrictionNode = $data[$restriction['@id']];
                                // Проверяем наличие pattern
                                if (!empty($restrictionNode['http://www.w3.org/2001/XMLSchema#pattern'])) {
                                    $pattern = $restrictionNode['http://www.w3.org/2001/XMLSchema#pattern'][0]['@value'] ?? null;

                                    // Определяем onProperty, связанный с ограничением
                                    foreach ($data as $property) {
                                        if (isset($property['http://www.w3.org/2000/01/rdf-schema#range'])) {
                                            foreach ($property['http://www.w3.org/2000/01/rdf-schema#range'] as $range) {
                                                if ($range['@id'] === $item['@id']) {
                                                    $onProperty = $property['@id'];
                                                    if ($onProperty && isset($properties[$onProperty]) && $pattern !== null) {
                                                        $properties[$onProperty]['pattern'] = $pattern;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $properties;
    }

    private function mapRangeToPhpType(?string $range, string $type, $data): ?string
    {
        if (!$range) {
            return null;
        }

        // Прямая проверка на основные типы
        $typeMapping = [
            'http://www.w3.org/2001/XMLSchema#string' => 'string',
            'http://www.w3.org/2001/XMLSchema#integer' => 'int',
            'http://www.w3.org/2001/XMLSchema#float' => 'float',
            'http://www.w3.org/2001/XMLSchema#boolean' => 'bool',
            'http://www.w3.org/2001/XMLSchema#duration' => 'string', //'P1D' BookingTimes
            'http://www.w3.org/2001/XMLSchema#dateTime' => '\DateTime',
            'http://www.w3.org/2001/XMLSchema#double' => 'float', //double in mysql

        ];

        // Если `range` напрямую соответствует типу данных
        if (isset($typeMapping[$range])) {
            return $typeMapping[$range];
        }

        // Если range — это ссылка на узел, ищем onDatatype
        if (isset($data[$range])) {
            $rangeNode = $data[$range];

            // Проверяем наличие onDatatype
            if (isset($rangeNode['http://www.w3.org/2002/07/owl#onDatatype'][0]['@id'])) {
                $onDatatype = $rangeNode['http://www.w3.org/2002/07/owl#onDatatype'][0]['@id'];
                if (isset($typeMapping[$onDatatype])) {
                    return $typeMapping[$onDatatype];
                }
            }

            // Если нет onDatatype, проверяем другие возможные данные
            if (isset($rangeNode['@type']) && in_array('http://www.w3.org/2000/01/rdf-schema#Datatype', $rangeNode['@type'])) {
                // Если тип данных явно указан как Datatype, но не маппится
                return 'mixed'; // Или обработка по-другому
            }
        }

        // Если это объектный тип
        if ($type === 'object') {
            return $range; // Возвращаем сам узел как ссылку на объектный тип
        }

        return null;
    }

    private function setRelationsForClass(array &$class): void
    {
        if (!empty($class['oneOff'])) {
            return;
        }
        foreach ($class['properties'] as $propertyId => &$property) {
            // Проверяем, является ли свойство объектным
            if ($property['type'] === 'object') {
                $property_class = $this->classes[$property['phpType']];
                $found = false;
                if (!empty($property_class['properties'])) {
                    foreach ($property_class['properties'] as $property_class_property) {
                        if ($property_class_property['type'] === 'object' && $property_class_property['phpType'] == $class['@id']) {
                            $found = true;
                            if (!empty($property_class_property['maxCardinality']) && !empty($property['maxCardinality'])) {
                                $class['properties'][$propertyId]['relation'] = 'OneToOne';
                            } elseif (!empty($property_class_property['maxCardinality']) && empty($property['maxCardinality'])) {
                                $class['properties'][$propertyId]['relation'] = 'OneToMany';
                                $class['properties'][$propertyId]['mappedBy'] = $property_class_property['label'];
//                            dump('OneToMany');
                            } elseif (empty($property_class_property['maxCardinality']) && !empty($property['maxCardinality'])) {
                                $class['properties'][$propertyId]['relation'] = 'ManyToOne';
                                $class['properties'][$propertyId]['inversedBy'] = $property_class_property['label'];
                            } elseif (empty($property_class_property['maxCardinality']) && empty($property['maxCardinality'])) {
                                $class['properties'][$propertyId]['relation'] = 'OneToMany';
                                $class['properties'][$propertyId]['mappedBy'] = $property_class_property['label'];
                            } else {
                                dump($class, 2);
                                die;
                            }
                        }
                    }
                }
                if (!$found) {
                    if (!empty($property['maxCardinality'])) {
                        $class['properties'][$propertyId]['relation'] = 'ManyToOne';
                        if (!empty($class['properties'][$propertyId]['phpType']) && str_contains($class['properties'][$propertyId]['phpType'], 'https://onerecord.iata.org/ns/coreCodeLists')) {
                            $class['properties'][$propertyId]['enum'] = $class['properties'][$propertyId]['phpType'];
                            $class['properties'][$propertyId]['phpType'] = 'string';
                            unset($class['properties'][$propertyId]['relation']);
                        }
                    } else {
                        if (!empty($class['properties'][$propertyId]['phpType']) && str_contains($class['properties'][$propertyId]['phpType'], 'https://onerecord.iata.org/ns/coreCodeLists')) {
                            $class['properties'][$propertyId]['jsonType'] = $class['properties'][$propertyId]['phpType'];
                            $class['properties'][$propertyId]['phpType'] = 'json';
                        } else {
                            $class['properties'][$propertyId]['relation'] = 'ManyToMany';
                            $class['properties'][$propertyId]['joinTable'] = strtolower(
                                $class['label'] . '_' . substr($class['properties'][$propertyId]['phpType'], strrpos($class['properties'][$propertyId]['phpType'], '#') + 1)
                            );
                            $class['properties'][$propertyId]['joinColumns'] = strtolower($class['label'] . '_id');
                            $class['properties'][$propertyId]['inverseJoinColumns'] = strtolower(
                                substr($class['properties'][$propertyId]['phpType'], strrpos($class['properties'][$propertyId]['phpType'], '#') + 1) . '_id'
                            );
                        }
                    }
                }
            } elseif ($property['type'] == 'datatype' && empty($property['maxCardinality']) && $property['phpType'] == 'string') {
                $property['phpType'] = 'json';
                $property['jsonType'] = 'string';
            }
        }
    }

    private function mapPropertiesToClass($properties, $data): void
    {
        // Перебираем все классы
        foreach ($this->classes as &$class) {
            if (!isset($class['properties'])) {
                $class['properties'] = [];
            }
            $subClassOf = array_column($class['http://www.w3.org/2000/01/rdf-schema#subClassOf'], '@id');
            foreach ($subClassOf as $subClassPropertyId) {
                if (isset($data[$subClassPropertyId])) {
                    $subClassData = $data[$subClassPropertyId];

                    // Проверяем наличие onProperty
                    if (isset($subClassData['http://www.w3.org/2002/07/owl#onProperty'][0]['@id'])) {
                        $propertyId = $subClassData['http://www.w3.org/2002/07/owl#onProperty'][0]['@id'];

                        // Добавляем свойство, если оно еще не добавлено
                        if (empty($class['properties'][$propertyId]) && isset($properties[$propertyId])) {
                            $class['properties'][$propertyId] = $properties[$propertyId];
                        }
                    }
                }
            }
            unset($class['http://www.w3.org/2000/01/rdf-schema#subClassOf']);
            if (!empty($class['properties'])) {
                $this->setRelationsForClass($class);
            }
        }
    }
}