<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.46 Aircraft Possibility Codes
 *
 * Options:
 * 1. BBF – Pure freighter flight carrying Loose Load Cargo
 * 2. BBQ – Mixed configuration (Combi) aircraft carrying Loose Load Cargo on the passenger deck
 * 3. BBV – Truck carrying Loose Load Cargo
 * 4. LLF – Pure freighter flight carrying Containerized Cargo (ULDs)
 * 5. LLJ – Passenger flight operated by wide-bodied aircraft carrying Containerized (ULDs)
 * 6. LLQ – Mixed configuration (Combi) aircraft carrying Containerized Cargo (ULDs) on the passenger deck
 * 7. LLV – Truck carrying Containerized Cargo (ULDs)
 * 8. LPF – Pure freighter flight carrying Containerized (ULDs)/Palletized Cargo
 * 9. LPJ – Passenger flight operated by wide-bodied aircraft carrying Containerized (ULDs)/ Palletized Cargo
 * 10. LPQ – Mixed configuration (Combi) aircraft carrying Containerized (ULDs)/Palletized Cargo on the passenger deck
 * 11. LPV – Truck carrying Containerized (ULDs)/Palletized Cargo
 * 12. PPF – Pure freighter flight carrying Palletized Cargo
 * 13. PPJ – Passenger flight operated by wide-bodied aircraft carrying Palletized Cargo
 * 14. PPQ – Mixed configuration aircraft carrying Palletized Cargo on the passenger deck
 * 15. PPV – Truck carrying Palletized Cargo
 *
 * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode Ontology
 */
#[Version('1.0.0')]
enum AircraftPossibilityCode: string
{
    /**
     * Pure freighter flight carrying Loose Load Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#BBF Ontology
     */
    case BBF = 'BBF';

    /**
     * Mixed configuration (Combi) aircraft carrying Loose Load Cargo on the passenger deck
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#BBQ Ontology
     */
    case BBQ = 'BBQ';

    /**
     * Truck carrying Loose Load Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#BBV Ontology
     */
    case BBV = 'BBV';

    /**
     * Pure freighter flight carrying Containerized Cargo (ULDs)
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#LLF Ontology
     */
    case LLF = 'LLF';

    /**
     * Passenger flight operated by wide-bodied aircraft carrying Containerized (ULDs)
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#LLJ Ontology
     */
    case LLJ = 'LLJ';

    /**
     * Mixed configuration (Combi) aircraft carrying Containerized Cargo (ULDs) on the passenger deck
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#LLQ Ontology
     */
    case LLQ = 'LLQ';

    /**
     * Truck carrying Containerized Cargo (ULDs)
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#LLV Ontology
     */
    case LLV = 'LLV';

    /**
     * Pure freighter flight carrying Containerized (ULDs)/Palletized Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#LPF Ontology
     */
    case LPF = 'LPF';

    /**
     * Passenger flight operated by wide-bodied aircraft carrying Containerized (ULDs)/ Palletized Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#LPJ Ontology
     */
    case LPJ = 'LPJ';

    /**
     * Mixed configuration (Combi) aircraft carrying Containerized (ULDs)/Palletized Cargo on the passenger deck
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#LPQ Ontology
     */
    case LPQ = 'LPQ';

    /**
     * Truck carrying Containerized (ULDs)/Palletized Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#LPV Ontology
     */
    case LPV = 'LPV';

    /**
     * Pure freighter flight carrying Palletized Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#PPF Ontology
     */
    case PPF = 'PPF';

    /**
     * Passenger flight operated by wide-bodied aircraft carrying Palletized Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#PPJ Ontology
     */
    case PPJ = 'PPJ';

    /**
     * Mixed configuration aircraft carrying Palletized Cargo on the passenger deck
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#PPQ Ontology
     */
    case PPQ = 'PPQ';

    /**
     * Truck carrying Palletized Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/AircraftPossibilityCode#PPV Ontology
     */
    case PPV = 'PPV';
}
