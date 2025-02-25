<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted sub-code list of length units from MeasurementUnitCode
 *
 * Options:
 * 1. CMT – Centimetre
 * 2. FOT – Foot
 * 3. INH – Inch
 * 4. MTR – Metre
 *
 * @link https://onerecord.iata.org/ns/code-lists/DimensionsUnitCode Ontology
 */
#[Version('1.0.0')]
enum DimensionsUnitCode: string
{
    /**
     * Centimetre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#CMT Ontology
     */
    case CMT = 'CMT';

    /**
     * Foot
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#FOT Ontology
     */
    case FOT = 'FOT';

    /**
     * Inch
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#INH Ontology
     */
    case INH = 'INH';

    /**
     * Metre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#MTR Ontology
     */
    case MTR = 'MTR';
}
