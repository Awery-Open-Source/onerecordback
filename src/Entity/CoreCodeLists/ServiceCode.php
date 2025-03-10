<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.38 Service Codes
 * Source: CSC Resolutions Manual, 25th Edition, Recommended Practice 1600d
 *
 * Options:
 * 1. A – Airport-to-Airport
 * 2. B – Service Shipment
 * 3. C – Company Material
 * 4. D – Door-to-Door Service
 * 5. E – Airport-to-Door
 * 6. F – Flight Specific
 * 7. G – Door-to-Airport
 * 8. H – Company Mail
 * 9. I – Diplomatic Mail
 * 10. J – Priority Service
 * 11. P – Small Package Service
 * 12. S – Substitute Truck
 * 13. T – Charter
 * 14. X – Express Shipments
 *
 * @link https://onerecord.iata.org/ns/code-lists/ServiceCode Ontology
 */
#[Version('1.0.0')]
enum ServiceCode: string
{
    /**
     * Airport-to-Airport
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#A Ontology
     */
    case A = 'A';

    /**
     * Service Shipment
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#B Ontology
     */
    case B = 'B';

    /**
     * Company Material
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#C Ontology
     */
    case C = 'C';

    /**
     * Door-to-Door Service
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#D Ontology
     */
    case D = 'D';

    /**
     * Airport-to-Door
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#E Ontology
     */
    case E = 'E';

    /**
     * Flight Specific
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#F Ontology
     */
    case F = 'F';

    /**
     * Door-to-Airport
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#G Ontology
     */
    case G = 'G';

    /**
     * Company Mail
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#H Ontology
     */
    case H = 'H';

    /**
     * Diplomatic Mail
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#I Ontology
     */
    case I = 'I';

    /**
     * Priority Service
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#J Ontology
     */
    case J = 'J';

    /**
     * Small Package Service
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#P Ontology
     */
    case P = 'P';

    /**
     * Substitute Truck
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#S Ontology
     */
    case S = 'S';

    /**
     * Charter
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#T Ontology
     */
    case T = 'T';

    /**
     * Express Shipments
     *
     * @link https://onerecord.iata.org/ns/code-lists/ServiceCode#X Ontology
     */
    case X = 'X';
}
