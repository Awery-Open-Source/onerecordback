<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list of purpose-of-transaction-codes
 * Source: CITES
 *
 * Options:
 * 1. B – Breeding in captivity or artificial propagation
 * 2. E – Educational
 * 3. G – Botanical garden
 * 4. H – Hunting trophy
 * 5. L – Law enforcement / judicial / forensic
 * 6. M – Medical (including biomedical research)
 * 7. N – Reintroduction or introduction into the wild
 * 8. P – Personal
 * 9. Q – Circus or travelling exhibition
 * 10. S – Scientific
 * 11. T – Commercial
 * 12. Z – Zoo
 *
 * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode Ontology
 */
#[Version('1.0.0')]
enum TransactionPurposeCode: string
{
    /**
     * Breeding in captivity or artificial propagation
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#B Ontology
     */
    case B = 'B';

    /**
     * Educational
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#E Ontology
     */
    case E = 'E';

    /**
     * Botanical garden
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#G Ontology
     */
    case G = 'G';

    /**
     * Hunting trophy
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#H Ontology
     */
    case H = 'H';

    /**
     * Law enforcement / judicial / forensic
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#L Ontology
     */
    case L = 'L';

    /**
     * Medical (including biomedical research)
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#M Ontology
     */
    case M = 'M';

    /**
     * Reintroduction or introduction into the wild
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#N Ontology
     */
    case N = 'N';

    /**
     * Personal
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#P Ontology
     */
    case P = 'P';

    /**
     * Circus or travelling exhibition
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#Q Ontology
     */
    case Q = 'Q';

    /**
     * Scientific
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#S Ontology
     */
    case S = 'S';

    /**
     * Commercial
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#T Ontology
     */
    case T = 'T';

    /**
     * Zoo
     *
     * @link https://onerecord.iata.org/ns/code-lists/TransactionPurposeCode#Z Ontology
     */
    case Z = 'Z';
}
