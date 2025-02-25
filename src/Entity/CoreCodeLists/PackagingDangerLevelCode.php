<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code lists for indication of the relative degree of danger presented by substances within a class or division
 *
 * Options:
 * 1. I – High danger
 * 2. II – Medium danger
 * 3. III – Low danger
 *
 * @link https://onerecord.iata.org/ns/code-lists/PackagingDangerLevelCode Ontology
 */
#[Version('1.0.0')]
enum PackagingDangerLevelCode: string
{
    /**
     * High danger
     *
     * @link https://onerecord.iata.org/ns/code-lists/PackagingDangerLevelCode#I Ontology
     */
    case I = 'I';

    /**
     * Medium danger
     *
     * @link https://onerecord.iata.org/ns/code-lists/PackagingDangerLevelCode#II Ontology
     */
    case II = 'II';

    /**
     * Low danger
     *
     * @link https://onerecord.iata.org/ns/code-lists/PackagingDangerLevelCode#III Ontology
     */
    case III = 'III';
}
