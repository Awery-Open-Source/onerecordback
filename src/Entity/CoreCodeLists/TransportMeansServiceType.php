<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list of possible transport means in transport legs in carrier bookings
 *
 * Options:
 * 1. FREIGHTER – Transport leg performed by freighter aircraft
 * 2. MIXED_CONFIGURATION_COMBI – Transport leg performed by mixed configuration combi aircraft
 * 3. PASSENGER – Transport leg performed by passenger aircraft
 * 4. TRUCK – Transport leg performed by truck
 *
 * @link https://onerecord.iata.org/ns/code-lists/TransportMeansServiceType Ontology
 */
#[Version('1.0.0')]
enum TransportMeansServiceType: string
{
    /**
     * Transport leg performed by freighter aircraft
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransportMeansServiceType#FREIGHTER Ontology
     */
    case FREIGHTER = 'FREIGHTER';

    /**
     * Transport leg performed by mixed configuration combi aircraft
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransportMeansServiceType#MIXED_CONFIGURATION_COMBI Ontology
     */
    case MIXED_CONFIGURATION_COMBI = 'MIXED_CONFIGURATION_COMBI';

    /**
     * Transport leg performed by passenger aircraft
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransportMeansServiceType#PASSENGER Ontology
     */
    case PASSENGER = 'PASSENGER';

    /**
     * Transport leg performed by truck
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransportMeansServiceType#TRUCK Ontology
     */
    case TRUCK = 'TRUCK';
}
