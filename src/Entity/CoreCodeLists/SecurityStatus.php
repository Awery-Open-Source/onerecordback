<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.103 Security Statuses
 *
 * Options:
 * 1. NSC – Cargo Has Not Been Secured Yet for Passenger or All-Cargo Aircraft
 * 2. SCO – Cargo Secure for All-Cargo Aircraft Only
 * 3. SHR – Secure for Passenger, All-Cargo and All-Mail Aircraft in Accordance with High Risk Requirements
 * 4. SPX – Cargo Secure for Passenger and All-Cargo Aircraft
 *
 * @link https://onerecord.iata.org/ns/code-lists/SecurityStatus Ontology
 */
#[Version('1.0.0')]
enum SecurityStatus: string
{
    /**
     * Cargo Has Not Been Secured Yet for Passenger or All-Cargo Aircraft
     *
     * @link https://onerecord.iata.org/ns/code-lists/SecurityStatus#NSC Ontology
     */
    case NSC = 'NSC';

    /**
     * Cargo Secure for All-Cargo Aircraft Only
     *
     * @link https://onerecord.iata.org/ns/code-lists/SecurityStatus#SCO Ontology
     */
    case SCO = 'SCO';

    /**
     * Secure for Passenger, All-Cargo and All-Mail Aircraft in Accordance with High Risk Requirements
     *
     * @link https://onerecord.iata.org/ns/code-lists/SecurityStatus#SHR Ontology
     */
    case SHR = 'SHR';

    /**
     * Cargo Secure for Passenger and All-Cargo Aircraft
     *
     * @link https://onerecord.iata.org/ns/code-lists/SecurityStatus#SPX Ontology
     */
    case SPX = 'SPX';
}
