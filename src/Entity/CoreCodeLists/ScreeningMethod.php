<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.102 Screening Methods
 *
 * Options:
 * 1. AOM – Subjected to Any Other Means
 * 2. CMD – Cargo Metal Detection
 * 3. EDD – Explosive Detection Dogs
 * 4. EDS – Explosive Detection System
 * 5. ETD – Explosives Trace Detection Equipment - Particles or Vapor
 * 6. PHS – Physical Inspection and/or Hand Search
 * 7. VCK – Visualcheck
 * 8. XRY – X-ray Equipment
 *
 * @link https://onerecord.iata.org/ns/code-lists/ScreeningMethod Ontology
 */
#[Version('1.0.0')]
enum ScreeningMethod: string
{
    /**
     * Subjected to Any Other Means
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningMethod#AOM Ontology
     */
    case AOM = 'AOM';

    /**
     * Cargo Metal Detection
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningMethod#CMD Ontology
     */
    case CMD = 'CMD';

    /**
     * Explosive Detection Dogs
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningMethod#EDD Ontology
     */
    case EDD = 'EDD';

    /**
     * Explosive Detection System
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningMethod#EDS Ontology
     */
    case EDS = 'EDS';

    /**
     * Explosives Trace Detection Equipment - Particles or Vapor
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningMethod#ETD Ontology
     */
    case ETD = 'ETD';

    /**
     * Physical Inspection and/or Hand Search
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningMethod#PHS Ontology
     */
    case PHS = 'PHS';

    /**
     * Visualcheck
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningMethod#VCK Ontology
     */
    case VCK = 'VCK';

    /**
     * X-ray Equipment
     *
     * @link https://onerecord.iata.org/ns/code-lists/ScreeningMethod#XRY Ontology
     */
    case XRY = 'XRY';
}
