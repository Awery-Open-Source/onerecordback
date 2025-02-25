<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list indicating whether a shipment is secured or not secured
 *
 * Options:
 * 1. NCR – Screened
 * 2. SCR – Not Screened
 *
 * @link https://onerecord.iata.org/ns/code-lists/ShipmentSecurityStatus Ontology
 */
#[Version('1.0.0')]
enum ShipmentSecurityStatus: string
{
    /**
     * Screened
     *
     * @link https://onerecord.iata.org/ns/code-lists/ShipmentSecurityStatus#NCR Ontology
     */
    case NCR = 'NCR';

    /**
     * Not Screened
     *
     * @link https://onerecord.iata.org/ns/code-lists/ShipmentSecurityStatus#SCR Ontology
     */
    case SCR = 'SCR';
}
