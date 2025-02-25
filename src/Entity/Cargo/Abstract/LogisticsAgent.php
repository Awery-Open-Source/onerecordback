<?php

namespace App\Entity\Cargo\Abstract;

use ApiPlatform\Metadata\ApiResource;
use App\Attribute\Version;
use Doctrine\ORM\Mapping as ORM;

/**
 * Superclass: LogisticsAgents describe acting entities in the logistics supply chain such as persons and organizations
 *
 * @link https://onerecord.iata.org/ns/cargo#LogisticsAgent Ontology
 */
#[ORM\Entity]
#[ApiResource]
#[Version('3.1 RC1')]
abstract class LogisticsAgent extends LogisticsObject
{
    public function __construct()
    {
        parent::__construct();
    }
}
