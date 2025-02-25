<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.33 Charge Identifiers
 *
 * Options:
 * 1. CN – CASS Net Amount
 * 2. CO – Commission
 * 3. CT – Charge Summary Total
 * 4. IN – Insurance
 * 5. NI – CASS Invoice Amount
 * 6. OA – Total Other Charges Due Agent
 * 7. OC – Total Other Charges Due Carrier
 * 8. SI – Sales Incentive
 * 9. TX – Taxes
 * 10. VC – Valuation Charge
 * 11. WT – Total Weight Charge
 *
 * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier Ontology
 */
#[Version('1.0.0')]
enum ChargeIdentifier: string
{
    /**
     * CASS Net Amount
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#CN Ontology
     */
    case CN = 'CN';

    /**
     * Commission
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#CO Ontology
     */
    case CO = 'CO';

    /**
     * Charge Summary Total
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#CT Ontology
     */
    case CT = 'CT';

    /**
     * Insurance
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#IN Ontology
     */
    case IN = 'IN';

    /**
     * CASS Invoice Amount
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#NI Ontology
     */
    case NI = 'NI';

    /**
     * Total Other Charges Due Agent
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#OA Ontology
     */
    case OA = 'OA';

    /**
     * Total Other Charges Due Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#OC Ontology
     */
    case OC = 'OC';

    /**
     * Sales Incentive
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#SI Ontology
     */
    case SI = 'SI';

    /**
     * Taxes
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#TX Ontology
     */
    case TX = 'TX';

    /**
     * Valuation Charge
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#VC Ontology
     */
    case VC = 'VC';

    /**
     * Total Weight Charge
     *
     * @link https://onerecord.iata.org/ns/code-lists/ChargeIdentifier#WT Ontology
     */
    case WT = 'WT';
}
