<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.1 Charge Codes
 * Source: CSC Resolutions Manual, 25th Edition, Resolution 600a
 *
 * Options:
 * 1. CA – Partial Collect Credit — Partial Prepaid Cash
 * 2. CB – Partial Collect Credit — Partial Prepaid Credit
 * 3. CC – All Charges Collect
 * 4. CE – Partial Collect Credit Card — Partial Prepaid Cash
 * 5. CG – All Charges Collect by GBL
 * 6. CH – Partial Collect Credit Card — Partial Prepaid Credit
 * 7. CM – Destination Collect by MCO
 * 8. CP – Destination Collect Cash
 * 9. CX – Destination Collect Credit
 * 10. CZ – All Charges Collect by Credit Card
 * 11. NC – No Charge
 * 12. NG – No Weight Charge — Other Charges Prepaid by GBL
 * 13. NP – No Weight Charge — Other Charges Prepaid Cash
 * 14. NT – No Weight Charge — Other Charges Collect
 * 15. NX – No Weight Charge — Other Charges Prepaid Credit
 * 16. NZ – No Weight Charge — Other Charges Prepaid by Credit Card
 * 17. PC – Partial Prepaid Cash — Partial Collect Cash
 * 18. PD – Partial Prepaid Credit — Partial Collect Cash
 * 19. PE – Partial Prepaid Credit Card — Partial Collect Cash
 * 20. PF – Partial Prepaid Credit Card — Partial Collect Credit Card
 * 21. PG – All Charges Prepaid by GBL
 * 22. PH – Partial Prepaid Credit Card — Partial Collect Credit
 * 23. PP – All Charges Prepaid Cash
 * 24. PX – All Charges Prepaid Credit
 * 25. PZ – All Charges Prepaid by Credit Card
 *
 * @link https://onerecord.iata.org/ns/code-lists/ChargeCode Ontology
 */
#[Version('1.0.0')]
enum ChargeCode: string
{
    /**
     * Partial Collect Credit — Partial Prepaid Cash
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CA Ontology
     */
    case CA = 'CA';

    /**
     * Partial Collect Credit — Partial Prepaid Credit
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CB Ontology
     */
    case CB = 'CB';

    /**
     * All Charges Collect
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CC Ontology
     */
    case CC = 'CC';

    /**
     * Partial Collect Credit Card — Partial Prepaid Cash
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CE Ontology
     */
    case CE = 'CE';

    /**
     * All Charges Collect by GBL
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CG Ontology
     */
    case CG = 'CG';

    /**
     * Partial Collect Credit Card — Partial Prepaid Credit
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CH Ontology
     */
    case CH = 'CH';

    /**
     * Destination Collect by MCO
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CM Ontology
     */
    case CM = 'CM';

    /**
     * Destination Collect Cash
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CP Ontology
     */
    case CP = 'CP';

    /**
     * Destination Collect Credit
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CX Ontology
     */
    case CX = 'CX';

    /**
     * All Charges Collect by Credit Card
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#CZ Ontology
     */
    case CZ = 'CZ';

    /**
     * No Charge
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#NC Ontology
     */
    case NC = 'NC';

    /**
     * No Weight Charge — Other Charges Prepaid by GBL
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#NG Ontology
     */
    case NG = 'NG';

    /**
     * No Weight Charge — Other Charges Prepaid Cash
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#NP Ontology
     */
    case NP = 'NP';

    /**
     * No Weight Charge — Other Charges Collect
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#NT Ontology
     */
    case NT = 'NT';

    /**
     * No Weight Charge — Other Charges Prepaid Credit
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#NX Ontology
     */
    case NX = 'NX';

    /**
     * No Weight Charge — Other Charges Prepaid by Credit Card
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#NZ Ontology
     */
    case NZ = 'NZ';

    /**
     * Partial Prepaid Cash — Partial Collect Cash
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#PC Ontology
     */
    case PC = 'PC';

    /**
     * Partial Prepaid Credit — Partial Collect Cash
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#PD Ontology
     */
    case PD = 'PD';

    /**
     * Partial Prepaid Credit Card — Partial Collect Cash
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#PE Ontology
     */
    case PE = 'PE';

    /**
     * Partial Prepaid Credit Card — Partial Collect Credit Card
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#PF Ontology
     */
    case PF = 'PF';

    /**
     * All Charges Prepaid by GBL
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#PG Ontology
     */
    case PG = 'PG';

    /**
     * Partial Prepaid Credit Card — Partial Collect Credit
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#PH Ontology
     */
    case PH = 'PH';

    /**
     * All Charges Prepaid Cash
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#PP Ontology
     */
    case PP = 'PP';

    /**
     * All Charges Prepaid Credit
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#PX Ontology
     */
    case PX = 'PX';

    /**
     * All Charges Prepaid by Credit Card
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeCode#PZ Ontology
     */
    case PZ = 'PZ';
}
