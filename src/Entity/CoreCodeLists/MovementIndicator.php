<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * NOT FINAL YET - Open code list corresponding to cXML code list 1.92 Movement Indicators
 *
 * Options:
 * 1. AA – Actual Arrival (Touchdown)
 * 2. AB – Actual On-block
 * 3. AD – Actual Departure (Take off)
 * 4. AG – Actual gate in time - Relates to gate passing of trucks
 * 5. AH – Actual gate out time - Relates t gate passing of trucks
 * 6. AK – Actual end of unloading time
 * 7. AL – Actual end of loading time
 * 8. AO – Actual Off-block
 * 9. AR – Actual driver reporting time
 * 10. CN – Cancellation
 * 11. DA – Doc Arrival
 * 12. DL – Delayed
 * 13. DV – Diversion
 * 14. EA – Estimated Arrival (Touchdown)
 * 15. EB – Estimated On-block
 * 16. ED – Estimated Departure (Take off)
 * 17. EK – Estimated end of unloading time
 * 18. EL – Estimated end of loading time
 * 19. EO – Estimated Off-block
 * 20. ER – Estimated driver reporting time
 * 21. FR – Force Return
 * 22. NI – Next Information
 * 23. PA – Pre-announcement of the truck - to enable to pre-announce data (driver name, license plates, etc.) to GHA at departure station
 * 24. RR – Return to RAMP
 * 25. SA – Scheduled Arrival
 * 26. SD – Scheduled Departure
 * 27. SK – Scheduled end of unloading time
 * 28. SL – Scheduled end of loading time
 * 29. SR – Scheduled latest driver reporting time for collection and/or delivery
 * 30. SS – Scheduled earliest driver reporting time for collection and/or delivery
 *
 * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator Ontology
 */
#[Version('1.0.0')]
enum MovementIndicator: string
{
    /**
     * Actual Arrival (Touchdown)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#AA Ontology
     */
    case AA = 'AA';

    /**
     * Actual On-block
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#AB Ontology
     */
    case AB = 'AB';

    /**
     * Actual Departure (Take off)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#AD Ontology
     */
    case AD = 'AD';

    /**
     * Actual gate in time - Relates to gate passing of trucks
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#AG Ontology
     */
    case AG = 'AG';

    /**
     * Actual gate out time - Relates t gate passing of trucks
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#AH Ontology
     */
    case AH = 'AH';

    /**
     * Actual end of unloading time
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#AK Ontology
     */
    case AK = 'AK';

    /**
     * Actual end of loading time
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#AL Ontology
     */
    case AL = 'AL';

    /**
     * Actual Off-block
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#AO Ontology
     */
    case AO = 'AO';

    /**
     * Actual driver reporting time
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#AR Ontology
     */
    case AR = 'AR';

    /**
     * Cancellation
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#CN Ontology
     */
    case CN = 'CN';

    /**
     * Doc Arrival
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#DA Ontology
     */
    case DA = 'DA';

    /**
     * Delayed
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#DL Ontology
     */
    case DL = 'DL';

    /**
     * Diversion
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#DV Ontology
     */
    case DV = 'DV';

    /**
     * Estimated Arrival (Touchdown)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#EA Ontology
     */
    case EA = 'EA';

    /**
     * Estimated On-block
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#EB Ontology
     */
    case EB = 'EB';

    /**
     * Estimated Departure (Take off)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#ED Ontology
     */
    case ED = 'ED';

    /**
     * Estimated end of unloading time
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#EK Ontology
     */
    case EK = 'EK';

    /**
     * Estimated end of loading time
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#EL Ontology
     */
    case EL = 'EL';

    /**
     * Estimated Off-block
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#EO Ontology
     */
    case EO = 'EO';

    /**
     * Estimated driver reporting time
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#ER Ontology
     */
    case ER = 'ER';

    /**
     * Force Return
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#FR Ontology
     */
    case FR = 'FR';

    /**
     * Next Information
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#NI Ontology
     */
    case NI = 'NI';

    /**
     * Pre-announcement of the truck - to enable to pre-announce data (driver name, license plates, etc.) to GHA at departure station
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#PA Ontology
     */
    case PA = 'PA';

    /**
     * Return to RAMP
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#RR Ontology
     */
    case RR = 'RR';

    /**
     * Scheduled Arrival
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#SA Ontology
     */
    case SA = 'SA';

    /**
     * Scheduled Departure
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#SD Ontology
     */
    case SD = 'SD';

    /**
     * Scheduled end of unloading time
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#SK Ontology
     */
    case SK = 'SK';

    /**
     * Scheduled end of loading time
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#SL Ontology
     */
    case SL = 'SL';

    /**
     * Scheduled latest driver reporting time for collection and/or delivery
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#SR Ontology
     */
    case SR = 'SR';

    /**
     * Scheduled earliest driver reporting time for collection and/or delivery
     *
     * @link https://onerecord.iata.org/ns/code-lists/MovementIndicator#SS Ontology
     */
    case SS = 'SS';
}
