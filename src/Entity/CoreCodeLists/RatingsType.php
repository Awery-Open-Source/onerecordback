<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list to describe whether a rating is Face, Published or Actual
 *
 * Options:
 * 1. A – Actual
 * 2. C – Published
 * 3. F – Face
 *
 * @link https://onerecord.iata.org/ns/code-lists/RatingsType Ontology
 */
#[Version('1.0.0')]
enum RatingsType: string
{
    /**
     * Actual
     *
     * @link https://onerecord.iata.org/ns/code-lists/RatingsType#A Ontology
     */
    case A = 'A';

    /**
     * Published
     *
     * @link https://onerecord.iata.org/ns/code-lists/RatingsType#C Ontology
     */
    case C = 'C';

    /**
     * Face
     *
     * @link https://onerecord.iata.org/ns/code-lists/RatingsType#F Ontology
     */
    case F = 'F';
}
