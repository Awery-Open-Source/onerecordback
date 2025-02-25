<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.104 Screening Exemptions
 *
 * Options:
 * 1. BIOM – Bio-Medical Samples
 * 2. DIPL – Diplomatic Bags or Diplomatic Mail
 * 3. LFSM – Life-Saving Materials (Save Human Life)
 * 4. MAIL – Mail
 * 5. NUCL – Nuclear Material
 * 6. SMUS – Small Undersized Shipments
 * 7. TRNS – Transfer or Transshipment
 *
 * @link https://onerecord.iata.org/ns/code-lists/ScreeningExemption Ontology
 */
#[Version('1.0.0')]
enum ScreeningExemption: string
{
    /**
     * Bio-Medical Samples
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningExemption#BIOM Ontology
     */
    case BIOM = 'BIOM';

    /**
     * Diplomatic Bags or Diplomatic Mail
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningExemption#DIPL Ontology
     */
    case DIPL = 'DIPL';

    /**
     * Life-Saving Materials (Save Human Life)
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningExemption#LFSM Ontology
     */
    case LFSM = 'LFSM';

    /**
     * Mail
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningExemption#MAIL Ontology
     */
    case MAIL = 'MAIL';

    /**
     * Nuclear Material
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningExemption#NUCL Ontology
     */
    case NUCL = 'NUCL';

    /**
     * Small Undersized Shipments
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningExemption#SMUS Ontology
     */
    case SMUS = 'SMUS';

    /**
     * Transfer or Transshipment
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningExemption#TRNS Ontology
     */
    case TRNS = 'TRNS';
}
