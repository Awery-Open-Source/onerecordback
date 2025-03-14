<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list based on DGR 10.3.3
 * Source: DGR 10.3.3 Nomenclature of radioactive material classification
 *
 * Options:
 * 1. LOW_DISPERSIBLE – Low Dispersible
 * 2. PHYSICAL_CHEMICAL_FORM – Physical Chemical Form
 * 3. SPECIAL_FORM – Special Form
 *
 * @link https://onerecord.iata.org/ns/code-lists/RadioactiveMaterialClassification Ontology
 */
#[Version('1.0.0')]
enum RadioactiveMaterialClassification: string
{
    /**
     * Low Dispersible
     *
     * @link https://onerecord.iata.org/ns/code-lists/RadioactiveMaterialClassification#LOW_DISPERSIBLE Ontology
     */
    case LOW_DISPERSIBLE = 'LOW_DISPERSIBLE';

    /**
     * Physical Chemical Form
     *
     * @link https://onerecord.iata.org/ns/code-lists/RadioactiveMaterialClassification#PHYSICAL_CHEMICAL_FORM Ontology
     */
    case PHYSICAL_CHEMICAL_FORM = 'PHYSICAL_CHEMICAL_FORM';

    /**
     * Special Form
     *
     * @link https://onerecord.iata.org/ns/code-lists/RadioactiveMaterialClassification#SPECIAL_FORM Ontology
     */
    case SPECIAL_FORM = 'SPECIAL_FORM';
}
