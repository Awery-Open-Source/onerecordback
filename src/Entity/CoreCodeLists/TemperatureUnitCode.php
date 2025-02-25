<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted sub-code list of temperature units from MeasurementUnitCode
 *
 * Options:
 * 1. CEL – Degree Celsius
 * 2. FAH – Degree Fahrenheit
 * 3. KEL – Kelvin
 *
 * @link https://onerecord.iata.org/ns/code-lists/TemperatureUnitCode Ontology
 */
#[Version('1.0.0')]
enum TemperatureUnitCode: string
{
    /**
     * Degree Celsius
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#CEL Ontology
     */
    case CEL = 'CEL';

    /**
     * Degree Fahrenheit
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#FAH Ontology
     */
    case FAH = 'FAH';

    /**
     * Kelvin
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#KEL Ontology
     */
    case KEL = 'KEL';
}
