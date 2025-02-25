<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list referring to the CITES source codes
 * Source: CITES
 *
 * Options:
 * 1. A – Artificially propagated plant
 * 2. C – Bred in captivity
 * 3. D – Captive-bred animal or artificially propagated plant
 * 4. F – Born in captivity
 * 5. I – Confiscated or seized
 * 6. O – Pre-Convention
 * 7. R – Ranched animal
 * 8. U – Unknown
 * 9. W – Wild
 * 10. X – Marine environment
 *
 * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode Ontology
 */
#[Version('1.0.0')]
enum GoodsTypeExtensionCode: string
{
    /**
     * Artificially propagated plant
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#A Ontology
     */
    case A = 'A';

    /**
     * Bred in captivity
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#C Ontology
     */
    case C = 'C';

    /**
     * Captive-bred animal or artificially propagated plant
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#D Ontology
     */
    case D = 'D';

    /**
     * Born in captivity
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#F Ontology
     */
    case F = 'F';

    /**
     * Confiscated or seized
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#I Ontology
     */
    case I = 'I';

    /**
     * Pre-Convention
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#O Ontology
     */
    case O = 'O';

    /**
     * Ranched animal
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#R Ontology
     */
    case R = 'R';

    /**
     * Unknown
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#U Ontology
     */
    case U = 'U';

    /**
     * Wild
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#W Ontology
     */
    case W = 'W';

    /**
     * Marine environment
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeExtensionCode#X Ontology
     */
    case X = 'X';
}
