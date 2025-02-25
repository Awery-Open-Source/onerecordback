<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.3 Entitlement Codes
 * Source: CSC Resolutions Manual, 25th Edition, Resolution 600a
 *
 * Options:
 * 1. A – Other Charges due Agent
 * 2. C – Other Charges due Carrier
 *
 * @link https://onerecord.iata.org/ns/code-lists/EntitlementCode Ontology
 */
#[Version('1.0.0')]
enum EntitlementCode: string
{
    /**
     * Other Charges due Agent
     *
     * @link https://onerecord.iata.org/ns/code-lists/EntitlementCode#A Ontology
     */
    case A = 'A';

    /**
     * Other Charges due Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/EntitlementCode#C Ontology
     */
    case C = 'C';
}
