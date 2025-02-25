<?php

namespace App\Entity\Cargo\Agent;

use ApiPlatform\Metadata\ApiResource;
use App\Attribute\Version;
use Doctrine\ORM\Mapping as ORM;

/**
 * PublicAuthorities are Organizations of the state on public interests, such as customs
 *
 * @link https://onerecord.iata.org/ns/cargo#PublicAuthority Ontology
 */
#[ORM\Entity]
#[ApiResource]
#[Version('3.1 RC1')]
class PublicAuthority extends Organization
{
    public function __construct()
    {
        parent::__construct();
    }
}
