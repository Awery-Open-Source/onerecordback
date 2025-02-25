<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.5 Prepaid/Collect Indicators
 *
 * Options:
 * 1. C – Collect Indicator
 * 2. P – Prepaid Indicator
 *
 * @link https://onerecord.iata.org/ns/code-lists/PrepaidCollectIndicator Ontology
 */
#[Version('1.0.0')]
enum PrepaidCollectIndicator: string
{
    /**
     * Collect Indicator
     *
     * @link https://onerecord.iata.org/ns/code-lists/PrepaidCollectIndicator#C Ontology
     */
    case C = 'C';

    /**
     * Prepaid Indicator
     *
     * @link https://onerecord.iata.org/ns/code-lists/PrepaidCollectIndicator#P Ontology
     */
    case P = 'P';
}
