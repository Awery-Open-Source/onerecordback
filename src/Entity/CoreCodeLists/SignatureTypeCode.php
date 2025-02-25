<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list of governmental action in CITES context
 * Source: CITES
 *
 * Options:
 * 1. DETENTION – Detention
 * 2. FUMIGATION – Fumigation
 * 3. INSPECTION – Inspection
 * 4. SECURITY – Security
 *
 * @link https://onerecord.iata.org/ns/code-lists/SignatureTypeCode Ontology
 */
#[Version('1.0.0')]
enum SignatureTypeCode: string
{
    /**
     * Detention
     *
     * @link https://onerecord.iata.org/ns/code-lists/SignatureTypeCode#DETENTION Ontology
     */
    case DETENTION = 'DETENTION';

    /**
     * Fumigation
     *
     * @link https://onerecord.iata.org/ns/code-lists/SignatureTypeCode#FUMIGATION Ontology
     */
    case FUMIGATION = 'FUMIGATION';

    /**
     * Inspection
     *
     * @link https://onerecord.iata.org/ns/code-lists/SignatureTypeCode#INSPECTION Ontology
     */
    case INSPECTION = 'INSPECTION';

    /**
     * Security
     *
     * @link https://onerecord.iata.org/ns/code-lists/SignatureTypeCode#SECURITY Ontology
     */
    case SECURITY = 'SECURITY';
}
