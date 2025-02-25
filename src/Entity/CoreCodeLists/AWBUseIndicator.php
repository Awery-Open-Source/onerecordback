<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list to describe Revenue, Service and Void AWBs based on CASS 2.0
 *
 * Options:
 * 1. R – Revenue AWB
 * 2. S – Service AWB
 * 3. V – Void AWB
 *
 * @link https://onerecord.iata.org/ns/code-lists/AWBUseIndicator Ontology
 */
#[Version('1.0.0')]
enum AWBUseIndicator: string
{
    /**
     * Revenue AWB
     *
     * @link https://onerecord.iata.org/ns/code-lists/AWBUseIndicator#R Ontology
     */
    case R = 'R';

    /**
     * Service AWB
     *
     * @link https://onerecord.iata.org/ns/code-lists/AWBUseIndicator#S Ontology
     */
    case S = 'S';

    /**
     * Void AWB
     *
     * @link https://onerecord.iata.org/ns/code-lists/AWBUseIndicator#V Ontology
     */
    case V = 'V';
}
