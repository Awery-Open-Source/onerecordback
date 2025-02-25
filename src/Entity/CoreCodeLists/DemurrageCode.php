<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list based on RP 1654
 * Source: CSC RP 1654
 *
 * Options:
 * 1. BCC – BCC
 * 2. HHH – HHH
 * 3. XXX – XXX
 * 4. ZZZ – ZZZ
 *
 * @link https://onerecord.iata.org/ns/code-lists/DemurrageCode Ontology
 */
#[Version('1.0.0')]
enum DemurrageCode: string
{
    /**
     * BCC
     *
     * @link https://onerecord.iata.org/ns/code-lists/DemurrageCode#BCC Ontology
     */
    case BCC = 'BCC';

    /**
     * HHH
     *
     * @link https://onerecord.iata.org/ns/code-lists/DemurrageCode#HHH Ontology
     */
    case HHH = 'HHH';

    /**
     * XXX
     *
     * @link https://onerecord.iata.org/ns/code-lists/DemurrageCode#XXX Ontology
     */
    case XXX = 'XXX';

    /**
     * ZZZ
     *
     * @link https://onerecord.iata.org/ns/code-lists/DemurrageCode#ZZZ Ontology
     */
    case ZZZ = 'ZZZ';
}
