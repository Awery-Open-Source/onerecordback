<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Open code list of indicators of how a package is marked
 *
 * Options:
 * 1. SSCC_18 – Serial Shipping Container Code-18 / EAN-18
 * 2. UPC – Universal Product Code
 *
 * @link https://onerecord.iata.org/ns/code-lists/PackageMarkCode Ontology
 */
#[Version('1.0.0')]
enum PackageMarkCode: string
{
    /**
     * Serial Shipping Container Code-18 / EAN-18
     *
     * @link https://onerecord.iata.org/ns/code-lists/PackageMarkCode#SSCC_18 Ontology
     */
    case SSCC_18 = 'SSCC_18';

    /**
     * Universal Product Code
     *
     * @link https://onerecord.iata.org/ns/code-lists/PackageMarkCode#UPC Ontology
     */
    case UPC = 'UPC';
}
