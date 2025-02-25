<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.21 ULD Condition Codes
 *
 * Options:
 * 1. DAM – Damaged But Still Serviceable
 * 2. SER – Serviceable
 *
 * @link https://onerecord.iata.org/ns/code-lists/ULDConditionCode Ontology
 */
#[Version('1.0.0')]
enum ULDConditionCode: string
{
    /**
     * Damaged But Still Serviceable
     *
     * @link https://onerecord.iata.org/ns/code-lists/ULDConditionCode#DAM Ontology
     */
    case DAM = 'DAM';

    /**
     * Serviceable
     *
     * @link https://onerecord.iata.org/ns/code-lists/ULDConditionCode#SER Ontology
     */
    case SER = 'SER';
}
