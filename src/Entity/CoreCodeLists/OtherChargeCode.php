<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.2 Other Charge Codes
 * Source: CSC Resolutions Manual, 25th Edition, Resolution 600a
 *
 * Options:
 * 1. AC – Animal Container
 * 2. AS – Assembly Service Fee
 * 3. AT – Attendant
 * 4. AW – Air Waybill Fee
 * 5. BA – Advances and/or guarantees
 * 6. BB – Appraisal Service
 * 7. BC – AWB Copy
 * 8. BE – Collection of funds
 * 9. BF – Copies of documents
 * 10. BH – Messenger service
 * 11. BI – Import/export documents processing
 * 12. BL – Blacklist Certificate
 * 13. BM – Withdrawal of shipment after clearance
 * 14. BR – Bank Release
 * 15. CA – Bonding
 * 16. CB – Completion/preparation of documents
 * 17. CC – Manual data entry for customs purposes
 * 18. CD – Clearance and Handling — Destination
 * 19. CE – Export/Import warrant
 * 20. CF – Inventory and/or inspection
 * 21. CG – Electronic processing or transmission of data for customs purposes
 * 22. CH – Clearance and Handling — Origin
 * 23. CI – Overtime and Other Customs Imposed Charges
 * 24. CJ – Removal (carrier warehouse to warehouse)
 * 25. DB – Disbursement Fee
 * 26. DC – Certificate of Origin
 * 27. DD – Preparation of Cargo manifest
 * 28. DF – Distribution Service Fee
 * 29. DG – AWB Cancellation
 * 30. DH – AWB Charges Correction Advice
 * 31. DI – AWB Re-waybilling
 * 32. DJ – Proof of delivery (documentation)
 * 33. DK – Release order
 * 34. DV – Veterinary and/or Phytosanitary purposes
 * 35. EA – Handling (Express)
 * 36. FA – Airport arrival
 * 37. FB – Domestic shipments
 * 38. FC – Charges Collect Fee
 * 39. FD – Priority
 * 40. FE – General (Handling)
 * 41. FF – Loading/unloading
 * 42. FI – Weighing
 * 43. GA – Diplomatic consignment
 * 44. GT – Government Tax
 * 45. HB – Mortuary
 * 46. HR – Human Remains
 * 47. IA – Very important cargo (VIC)
 * 48. IN – Insurance Premium
 * 49. JA – Clearance, General
 * 50. KA – Handling (Heavy/Bulky cargo)
 * 51. KB – Loading/unloading equipment (forklift etc.)
 * 52. LA – Live Animals
 * 53. LC – Cleaning
 * 54. LE – Hotel
 * 55. LF – Quarantine
 * 56. LG – Veterinary inspection
 * 57. LH – Storage (Live animals)
 * 58. LI – Cleaning of stalls/pens
 * 59. LJ – Rental of Stalls/pens
 * 60. MA – Miscellaneous — Due Agent (see Note 1)
 * 61. MB – Miscellaneous — Unassigned (see Note 2)
 * 62. MC – Miscellaneous — Due Carrier (see Note 3)
 * 63. MD – Miscellaneous — Due Last Carrier
 * 64. ME – Miscellaneous — Due Last Carrier
 * 65. MF – Miscellaneous — Due Last Carrier
 * 66. MG – Miscellaneous — Due Last Carrier
 * 67. MH – Miscellaneous — Due Last Carrier
 * 68. MI – Miscellaneous — Due Last Carrier
 * 69. MJ – Miscellaneous — Due Last Carrier
 * 70. MK – Miscellaneous — Due Last Carrier
 * 71. ML – Miscellaneous — Due Last Carrier
 * 72. MM – Miscellaneous — Due Last Carrier
 * 73. MN – Miscellaneous — Due Last Carrier
 * 74. MO – Miscellaneous — Due Issuing Carrier
 * 75. MP – Miscellaneous — Due Issuing Carrier
 * 76. MQ – Miscellaneous — Due Issuing Carrier
 * 77. MR – Miscellaneous — Due Issuing Carrier
 * 78. MS – Miscellaneous — Due Issuing Carrier
 * 79. MT – Miscellaneous — Due Issuing Carrier
 * 80. MU – Miscellaneous — Due Issuing Carrier
 * 81. MV – Miscellaneous — Due Issuing Carrier
 * 82. MW – Miscellaneous — Due Issuing Carrier
 * 83. MX – Miscellaneous — Due Issuing Carrier
 * 84. MY – Fuel Surcharge — Due Issuing Carrier
 * 85. MZ – Miscellaneous — Due Issuing Carrier
 * 86. NS – Navigation Surcharge — Due Issuing Carrier
 * 87. PA – Handling (Perishables)
 * 88. PB – Cool/Cold room, freezer (Perishables)
 * 89. PK – Packing/Repacking
 * 90. PU – Pick-Up
 * 91. RA – Dangerous Goods Fee
 * 92. RB – Rejection
 * 93. RC – Referral of Charge
 * 94. RD – Radio-active room
 * 95. RF – Remit Following Collection Fee
 * 96. SA – Delivery
 * 97. SB – Delivery notification
 * 98. SC – Security Charge
 * 99. SD – Surface Charge — Destination
 * 100. SE – Proof of delivery (pickup and delivery)
 * 101. SF – Delivery Order
 * 102. SI – Stop in Transit
 * 103. SO – Storage — Origin
 * 104. SP – Separate Early Release
 * 105. SR – Storage — Destination
 * 106. SS – Signature Service
 * 107. ST – State Sales Tax
 * 108. SU – Surface Charge — Origin
 * 109. TA – Postal Tax
 * 110. TB – Sales Tax
 * 111. TC – Stamp Tax
 * 112. TD – State Tax
 * 113. TE – Statistical Tax
 * 114. TI – Value Added Tax (For Import only)
 * 115. TR – Transit
 * 116. TV – Value Added Tax (General or for Export)
 * 117. TX – General Taxes
 * 118. UB – Disassembly
 * 119. UC – Adjusting of improperly loaded ULD
 * 120. UD – Demurrage
 * 121. UE – Leasing
 * 122. UF – Recontouring
 * 123. UG – Unloading (Unit Load Device)
 * 124. UH – Handling (Unit Load Device)
 * 125. VA – Handling (Valuable Cargo)
 * 126. VB – Security (armed guard/escort) handling
 * 127. VC – Strongroom
 * 128. WA – Handling (Vulnerable cargo)
 * 129. XB – Security (Surcharge/premiums)
 * 130. XC – Time
 * 131. XD – War risk
 * 132. XE – Weight
 * 133. ZA – Re-warehousing
 * 134. ZB – General (Storage)
 * 135. ZC – Cool/Cold room, freezer (Storage)
 *
 * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode Ontology
 */
#[Version('1.0.0')]
enum OtherChargeCode: string
{
    /**
     * Animal Container
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#AC Ontology
     */
    case AC = 'AC';

    /**
     * Assembly Service Fee
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#AS Ontology
     */
    case AS = 'AS';

    /**
     * Attendant
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#AT Ontology
     */
    case AT = 'AT';

    /**
     * Air Waybill Fee
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#AW Ontology
     */
    case AW = 'AW';

    /**
     * Advances and/or guarantees
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BA Ontology
     */
    case BA = 'BA';

    /**
     * Appraisal Service
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BB Ontology
     */
    case BB = 'BB';

    /**
     * AWB Copy
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BC Ontology
     */
    case BC = 'BC';

    /**
     * Collection of funds
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BE Ontology
     */
    case BE = 'BE';

    /**
     * Copies of documents
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BF Ontology
     */
    case BF = 'BF';

    /**
     * Messenger service
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BH Ontology
     */
    case BH = 'BH';

    /**
     * Import/export documents processing
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BI Ontology
     */
    case BI = 'BI';

    /**
     * Blacklist Certificate
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BL Ontology
     */
    case BL = 'BL';

    /**
     * Withdrawal of shipment after clearance
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BM Ontology
     */
    case BM = 'BM';

    /**
     * Bank Release
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#BR Ontology
     */
    case BR = 'BR';

    /**
     * Bonding
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CA Ontology
     */
    case CA = 'CA';

    /**
     * Completion/preparation of documents
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CB Ontology
     */
    case CB = 'CB';

    /**
     * Manual data entry for customs purposes
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CC Ontology
     */
    case CC = 'CC';

    /**
     * Clearance and Handling — Destination
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CD Ontology
     */
    case CD = 'CD';

    /**
     * Export/Import warrant
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CE Ontology
     */
    case CE = 'CE';

    /**
     * Inventory and/or inspection
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CF Ontology
     */
    case CF = 'CF';

    /**
     * Electronic processing or transmission of data for customs purposes
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CG Ontology
     */
    case CG = 'CG';

    /**
     * Clearance and Handling — Origin
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CH Ontology
     */
    case CH = 'CH';

    /**
     * Overtime and Other Customs Imposed Charges
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CI Ontology
     */
    case CI = 'CI';

    /**
     * Removal (carrier warehouse to warehouse)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#CJ Ontology
     */
    case CJ = 'CJ';

    /**
     * Disbursement Fee
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DB Ontology
     */
    case DB = 'DB';

    /**
     * Certificate of Origin
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DC Ontology
     */
    case DC = 'DC';

    /**
     * Preparation of Cargo manifest
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DD Ontology
     */
    case DD = 'DD';

    /**
     * Distribution Service Fee
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DF Ontology
     */
    case DF = 'DF';

    /**
     * AWB Cancellation
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DG Ontology
     */
    case DG = 'DG';

    /**
     * AWB Charges Correction Advice
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DH Ontology
     */
    case DH = 'DH';

    /**
     * AWB Re-waybilling
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DI Ontology
     */
    case DI = 'DI';

    /**
     * Proof of delivery (documentation)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DJ Ontology
     */
    case DJ = 'DJ';

    /**
     * Release order
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DK Ontology
     */
    case DK = 'DK';

    /**
     * Veterinary and/or Phytosanitary purposes
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#DV Ontology
     */
    case DV = 'DV';

    /**
     * Handling (Express)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#EA Ontology
     */
    case EA = 'EA';

    /**
     * Airport arrival
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#FA Ontology
     */
    case FA = 'FA';

    /**
     * Domestic shipments
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#FB Ontology
     */
    case FB = 'FB';

    /**
     * Charges Collect Fee
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#FC Ontology
     */
    case FC = 'FC';

    /**
     * Priority
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#FD Ontology
     */
    case FD = 'FD';

    /**
     * General (Handling)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#FE Ontology
     */
    case FE = 'FE';

    /**
     * Loading/unloading
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#FF Ontology
     */
    case FF = 'FF';

    /**
     * Weighing
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#FI Ontology
     */
    case FI = 'FI';

    /**
     * Diplomatic consignment
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#GA Ontology
     */
    case GA = 'GA';

    /**
     * Government Tax
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#GT Ontology
     */
    case GT = 'GT';

    /**
     * Mortuary
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#HB Ontology
     */
    case HB = 'HB';

    /**
     * Human Remains
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#HR Ontology
     */
    case HR = 'HR';

    /**
     * Very important cargo (VIC)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#IA Ontology
     */
    case IA = 'IA';

    /**
     * Insurance Premium
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#IN Ontology
     */
    case IN = 'IN';

    /**
     * Clearance, General
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#JA Ontology
     */
    case JA = 'JA';

    /**
     * Handling (Heavy/Bulky cargo)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#KA Ontology
     */
    case KA = 'KA';

    /**
     * Loading/unloading equipment (forklift etc.)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#KB Ontology
     */
    case KB = 'KB';

    /**
     * Live Animals
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#LA Ontology
     */
    case LA = 'LA';

    /**
     * Cleaning
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#LC Ontology
     */
    case LC = 'LC';

    /**
     * Hotel
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#LE Ontology
     */
    case LE = 'LE';

    /**
     * Quarantine
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#LF Ontology
     */
    case LF = 'LF';

    /**
     * Veterinary inspection
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#LG Ontology
     */
    case LG = 'LG';

    /**
     * Storage (Live animals)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#LH Ontology
     */
    case LH = 'LH';

    /**
     * Cleaning of stalls/pens
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#LI Ontology
     */
    case LI = 'LI';

    /**
     * Rental of Stalls/pens
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#LJ Ontology
     */
    case LJ = 'LJ';

    /**
     * Miscellaneous — Due Agent (see Note 1)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MA Ontology
     */
    case MA = 'MA';

    /**
     * Miscellaneous — Unassigned (see Note 2)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MB Ontology
     */
    case MB = 'MB';

    /**
     * Miscellaneous — Due Carrier (see Note 3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MC Ontology
     */
    case MC = 'MC';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MD Ontology
     */
    case MD = 'MD';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#ME Ontology
     */
    case ME = 'ME';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MF Ontology
     */
    case MF = 'MF';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MG Ontology
     */
    case MG = 'MG';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MH Ontology
     */
    case MH = 'MH';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MI Ontology
     */
    case MI = 'MI';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MJ Ontology
     */
    case MJ = 'MJ';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MK Ontology
     */
    case MK = 'MK';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#ML Ontology
     */
    case ML = 'ML';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MM Ontology
     */
    case MM = 'MM';

    /**
     * Miscellaneous — Due Last Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MN Ontology
     */
    case MN = 'MN';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MO Ontology
     */
    case MO = 'MO';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MP Ontology
     */
    case MP = 'MP';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MQ Ontology
     */
    case MQ = 'MQ';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MR Ontology
     */
    case MR = 'MR';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MS Ontology
     */
    case MS = 'MS';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MT Ontology
     */
    case MT = 'MT';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MU Ontology
     */
    case MU = 'MU';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MV Ontology
     */
    case MV = 'MV';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MW Ontology
     */
    case MW = 'MW';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MX Ontology
     */
    case MX = 'MX';

    /**
     * Fuel Surcharge — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MY Ontology
     */
    case MY = 'MY';

    /**
     * Miscellaneous — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#MZ Ontology
     */
    case MZ = 'MZ';

    /**
     * Navigation Surcharge — Due Issuing Carrier
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#NS Ontology
     */
    case NS = 'NS';

    /**
     * Handling (Perishables)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#PA Ontology
     */
    case PA = 'PA';

    /**
     * Cool/Cold room, freezer (Perishables)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#PB Ontology
     */
    case PB = 'PB';

    /**
     * Packing/Repacking
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#PK Ontology
     */
    case PK = 'PK';

    /**
     * Pick-Up
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#PU Ontology
     */
    case PU = 'PU';

    /**
     * Dangerous Goods Fee
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#RA Ontology
     */
    case RA = 'RA';

    /**
     * Rejection
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#RB Ontology
     */
    case RB = 'RB';

    /**
     * Referral of Charge
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#RC Ontology
     */
    case RC = 'RC';

    /**
     * Radio-active room
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#RD Ontology
     */
    case RD = 'RD';

    /**
     * Remit Following Collection Fee
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#RF Ontology
     */
    case RF = 'RF';

    /**
     * Delivery
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SA Ontology
     */
    case SA = 'SA';

    /**
     * Delivery notification
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SB Ontology
     */
    case SB = 'SB';

    /**
     * Security Charge
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SC Ontology
     */
    case SC = 'SC';

    /**
     * Surface Charge — Destination
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SD Ontology
     */
    case SD = 'SD';

    /**
     * Proof of delivery (pickup and delivery)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SE Ontology
     */
    case SE = 'SE';

    /**
     * Delivery Order
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SF Ontology
     */
    case SF = 'SF';

    /**
     * Stop in Transit
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SI Ontology
     */
    case SI = 'SI';

    /**
     * Storage — Origin
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SO Ontology
     */
    case SO = 'SO';

    /**
     * Separate Early Release
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SP Ontology
     */
    case SP = 'SP';

    /**
     * Storage — Destination
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SR Ontology
     */
    case SR = 'SR';

    /**
     * Signature Service
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SS Ontology
     */
    case SS = 'SS';

    /**
     * State Sales Tax
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#ST Ontology
     */
    case ST = 'ST';

    /**
     * Surface Charge — Origin
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#SU Ontology
     */
    case SU = 'SU';

    /**
     * Postal Tax
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#TA Ontology
     */
    case TA = 'TA';

    /**
     * Sales Tax
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#TB Ontology
     */
    case TB = 'TB';

    /**
     * Stamp Tax
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#TC Ontology
     */
    case TC = 'TC';

    /**
     * State Tax
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#TD Ontology
     */
    case TD = 'TD';

    /**
     * Statistical Tax
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#TE Ontology
     */
    case TE = 'TE';

    /**
     * Value Added Tax (For Import only)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#TI Ontology
     */
    case TI = 'TI';

    /**
     * Transit
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#TR Ontology
     */
    case TR = 'TR';

    /**
     * Value Added Tax (General or for Export)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#TV Ontology
     */
    case TV = 'TV';

    /**
     * General Taxes
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#TX Ontology
     */
    case TX = 'TX';

    /**
     * Disassembly
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#UB Ontology
     */
    case UB = 'UB';

    /**
     * Adjusting of improperly loaded ULD
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#UC Ontology
     */
    case UC = 'UC';

    /**
     * Demurrage
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#UD Ontology
     */
    case UD = 'UD';

    /**
     * Leasing
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#UE Ontology
     */
    case UE = 'UE';

    /**
     * Recontouring
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#UF Ontology
     */
    case UF = 'UF';

    /**
     * Unloading (Unit Load Device)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#UG Ontology
     */
    case UG = 'UG';

    /**
     * Handling (Unit Load Device)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#UH Ontology
     */
    case UH = 'UH';

    /**
     * Handling (Valuable Cargo)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#VA Ontology
     */
    case VA = 'VA';

    /**
     * Security (armed guard/escort) handling
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#VB Ontology
     */
    case VB = 'VB';

    /**
     * Strongroom
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#VC Ontology
     */
    case VC = 'VC';

    /**
     * Handling (Vulnerable cargo)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#WA Ontology
     */
    case WA = 'WA';

    /**
     * Security (Surcharge/premiums)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#XB Ontology
     */
    case XB = 'XB';

    /**
     * Time
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#XC Ontology
     */
    case XC = 'XC';

    /**
     * War risk
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#XD Ontology
     */
    case XD = 'XD';

    /**
     * Weight
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#XE Ontology
     */
    case XE = 'XE';

    /**
     * Re-warehousing
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#ZA Ontology
     */
    case ZA = 'ZA';

    /**
     * General (Storage)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#ZB Ontology
     */
    case ZB = 'ZB';

    /**
     * Cool/Cold room, freezer (Storage)
     *
     * @link https://onerecord.iata.org/ns/code-lists/OtherChargeCode#ZC Ontology
     */
    case ZC = 'ZC';
}
