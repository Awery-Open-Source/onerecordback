<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list based on cXML code list 1.84 Category Colour
 *
 * Options:
 * 1. III_YELLOW – III-Yellow
 * 2. II_YELLOW – II-Yellow
 * 3. I_WHITE – I-Yellow
 *
 * @link https://onerecord.iata.org/ns/code-lists/RaTypeCode Ontology
 */
#[Version('1.0.0')]
enum RaTypeCode: string
{
    /**
     * III-Yellow
     *
     * @link https://onerecord.iata.org/ns/code-lists/RaTypeCode#III_YELLOW Ontology
     */
    case III_YELLOW = 'III_YELLOW';

    /**
     * II-Yellow
     *
     * @link https://onerecord.iata.org/ns/code-lists/RaTypeCode#II_YELLOW Ontology
     */
    case II_YELLOW = 'II_YELLOW';

    /**
     * I-Yellow
     *
     * @link https://onerecord.iata.org/ns/code-lists/RaTypeCode#I_WHITE Ontology
     */
    case I_WHITE = 'I_WHITE';
}
