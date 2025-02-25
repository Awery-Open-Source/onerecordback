<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted sub-code list of weight units from MeasurementUnitCode
 *
 * Options:
 * 1. KGM – Kilogram
 * 2. LBR – Pound UK, US (0.45359237 KGM)
 * 3. ONZ – Ounce UK, US (28.949523 GRM)
 *
 * @link https://onerecord.iata.org/ns/code-lists/WeightUnitCode Ontology
 */
#[Version('1.0.0')]
enum WeightUnitCode: string
{
    /**
     * Kilogram
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#KGM Ontology
     */
    case KGM = 'KGM';

    /**
     * Pound UK, US (0.45359237 KGM)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#LBR Ontology
     */
    case LBR = 'LBR';

    /**
     * Ounce UK, US (28.949523 GRM)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#ONZ Ontology
     */
    case ONZ = 'ONZ';
}
