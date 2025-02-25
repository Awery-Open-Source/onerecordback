<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted sub-code list corresponding to elements of cXML code list 1.4 Rate Class Codes
 * Source: CSC Resolutions Manual, 25th Edition, Resolution 600a
 *
 * Options:
 * 1. C – Specific Commodity Rate
 * 2. M – Minimum Charge
 * 3. N – Normal Rate
 * 4. Q – Quantity Rate
 * 5. U – Unit Load Device Basic Charge or Rate
 *
 * @link https://onerecord.iata.org/ns/code-lists/BasicRateClassCode Ontology
 */
#[Version('1.0.0')]
enum BasicRateClassCode: string
{
    /**
     * Specific Commodity Rate
     *
     * @link https://onerecord.iata.org/ns/code-lists/RateClassCode#C Ontology
     */
    case C = 'C';

    /**
     * Minimum Charge
     *
     * @link https://onerecord.iata.org/ns/code-lists/RateClassCode#M Ontology
     */
    case M = 'M';

    /**
     * Normal Rate
     *
     * @link https://onerecord.iata.org/ns/code-lists/RateClassCode#N Ontology
     */
    case N = 'N';

    /**
     * Quantity Rate
     *
     * @link https://onerecord.iata.org/ns/code-lists/RateClassCode#Q Ontology
     */
    case Q = 'Q';

    /**
     * Unit Load Device Basic Charge or Rate
     *
     * @link https://onerecord.iata.org/ns/code-lists/RateClassCode#U Ontology
     */
    case U = 'U';
}
