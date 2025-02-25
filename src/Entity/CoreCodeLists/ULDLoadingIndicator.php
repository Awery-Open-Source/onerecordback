<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.47 ULD Loading Indicators
 *
 * Options:
 * 1. L – ULD Height below 160 centimetres
 * 2. M – Main Deck Loading only
 * 3. N – Nose Door Loading only
 * 4. R – ULD Height above 244 centimetres
 * 5. U – ULD Height between 160 centimetres and 244 centimetres
 *
 * @link https://onerecord.iata.org/ns/code-lists/ULDLoadingIndicator Ontology
 */
#[Version('1.0.0')]
enum ULDLoadingIndicator: string
{
    /**
     * ULD Height below 160 centimetres
     *
     * @link https://onerecord.iata.org/ns/code-lists/ULDLoadingIndicator#L Ontology
     */
    case L = 'L';

    /**
     * Main Deck Loading only
     *
     * @link https://onerecord.iata.org/ns/code-lists/ULDLoadingIndicator#M Ontology
     */
    case M = 'M';

    /**
     * Nose Door Loading only
     *
     * @link https://onerecord.iata.org/ns/code-lists/ULDLoadingIndicator#N Ontology
     */
    case N = 'N';

    /**
     * ULD Height above 244 centimetres
     *
     * @link https://onerecord.iata.org/ns/code-lists/ULDLoadingIndicator#R Ontology
     */
    case R = 'R';

    /**
     * ULD Height between 160 centimetres and 244 centimetres
     *
     * @link https://onerecord.iata.org/ns/code-lists/ULDLoadingIndicator#U Ontology
     */
    case U = 'U';
}
