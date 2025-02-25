<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Open code list corresponding to cXML code lists 1.16 Special Handling Codes, 1.14 Dangerous Goods Codes and 1.103 Security Statuses. Note that the codes from 1.14 and 1.103 have different IRI prefixes
 * Source of DGR codes: Dangerous Goods Regulations, 46th Edition
 *
 * Options:
 * 1. ACT – Active Temperature Controlled System
 * 2. AOG – Aircraft on Ground
 * 3. ATT – Goods Attached to Air Waybill
 * 4. AVI – Live Animal
 * 5. BIG – Outsized
 * 6. BUP – Bulk Unitization Programme, Shipper/Consignee Handled Unit
 * 7. CAO – Cargo Aircraft Only
 * 8. CAT – Cargo Attendant Accompanying Shipment
 * 9. CIC – Cargo may be loaded in the passenger cabin
 * 10. COL – Cool Goods
 * 11. COM – Company Mail
 * 12. CRT – Control Room Temperature +15°C to +25°C
 * 13. DIP – Diplomatic Mail
 * 14. EAP – e-freight Consignment with Accompanying Paper Documents
 * 15. EAT – Foodstuffs
 * 16. EAW – e-freight Consignment with No Accompanying Paper Documents
 * 17. EBI – Lithium ion batteries excepted as per Section II of PI 965
 * 18. EBM – Lithium metal batteries excepted as per Section II of PI 968
 * 19. ECC – Consignment established with an electronically concluded cargo contract with no accompanying paper airwaybill
 * 20. ECP – Consignment established with a paper air waybill contract being printed under an e-AWB agreement
 * 21. ELI – Lithium Ion Batteries otherwise excepted from the IATA DGR
 * 22. ELM – Lithium Metal Batteries otherwise excepted from the IATA DGR
 * 23. EMD – Electronic Monitoring Devices on/in Cargo/Container
 * 24. ERT – Extended Room Temperature +2°C to +25°C
 * 25. FIL – Undeveloped/Unexposed Film
 * 26. FRI – Frozen Goods Subject to Veterinary/Phytosanitary Inspections
 * 27. FRO – Frozen Goods
 * 28. GOH – Hanging Garments
 * 29. HEA – Heavy Cargo/150 kilograms and over per piece
 * 30. HEG – Hatching Eggs
 * 31. HUM – Human Remains in Coffin
 * 32. ICE – Dry Ice
 * 33. LHO – Living Human Organs/Blood
 * 34. LIC – License Required
 * 35. MAG – Magnetized Material
 * 36. MAL – Mail
 * 37. MUW – Munitions of War
 * 38. NSC – Cargo Has Not Been Secured Yet for Passenger or All-Cargo Aircraft
 * 39. NST – Non Stackable Cargo
 * 40. NWP – Newspapers, Magazines
 * 41. OBX – Obnoxious Cargo
 * 42. OHG – Overhang Item
 * 43. PAC – Passenger and Cargo
 * 44. PEA – Hunting trophies, skin, hide and all articles made from or containing parts of species listed in the CITES (Convention on International Trade in Endangered Species) appendices
 * 45. PEB – Animal products for non-human consumption
 * 46. PEF – Flowers
 * 47. PEM – Meat
 * 48. PEP – Fruits and Vegetables
 * 49. PER – Perishable Cargo
 * 50. PES – Fish/Seafood
 * 51. PHY – Goods subject to phytosanitary inspections
 * 52. PIL – Pharmaceuticals
 * 53. PIP – Passive Insulated Packaging
 * 54. QRT – Quick Ramp Transfer
 * 55. RAC – Reserved Air Cargo
 * 56. RBI – Fully regulated lithium ion batteries (Class 9, UN 3480) as per Section IA and IB of PI 965
 * 57. RBM – Fully regulated lithium metal batteries (Class 9, UN 3090) as per Section IA and IB of PI 968
 * 58. RCL – Cryogenic Liquids
 * 59. RCM – Corrosive
 * 60. RCX – Explosives 1.3C
 * 61. RDS – Diagnostic Specimens
 * 62. REQ – Excepted Quantities of Dangerous Goods
 * 63. REX – To be reserved for normally forbidden Explosives, Divisions 1.1, 1.2, 1.3, 1.4F, 1.5 and 1.6
 * 64. RFG – Flammable Gas
 * 65. RFL – Flammable Liquid
 * 66. RFS – Flammable Solid
 * 67. RFW – Dangerous When Wet
 * 68. RGX – Explosives 1.3G
 * 69. RIS – Infectious Substance
 * 70. RLI – Fully Regulated Lithium Ion Batteries (Class 9)
 * 71. RLM – Fully Regulated Lithium Metal Batteries (Class 9)
 * 72. RMD – Miscellaneous Dangerous Goods
 * 73. RNG – Non-Flammable Non-Toxic Gas
 * 74. ROP – Organic Peroxide
 * 75. ROX – Oxidizer
 * 76. RPB – Toxic Substance
 * 77. RPG – Toxic Gas
 * 78. RRE – Excepted Quantities of Radioactive Material
 * 79. RRW – Radioactive Material Category I-White
 * 80. RRY – Radioactive Material Categories II-Yellow and III-Yellow
 * 81. RSB – Polymeric Beads
 * 82. RSC – Spontaneously Combustible
 * 83. RXB – Explosives 1.4B
 * 84. RXC – Explosives 1.4C
 * 85. RXD – Explosives 1.4D
 * 86. RXE – Explosives 1.4E
 * 87. RXG – Explosives 1.4G
 * 88. RXS – Explosives 1.4S
 * 89. SCO – Cargo Secure for All-Cargo Aircraft Only
 * 90. SHL – Save Human Life
 * 91. SHR – Secure for Passenger, All-Cargo and All-Mail Aircraft in Accordance with High Risk Requirements
 * 92. SPF – Laboratory Animals
 * 93. SPX – Cargo Secure for Passenger and All-Cargo Aircraft
 * 94. SUR – Surface Transportation
 * 95. SWP – Sporting Weapons
 * 96. VAL – Valuable Cargo
 * 97. VIC – Very Important Cargo
 * 98. VOL – Volume
 * 99. VUN – Vulnerable Cargo
 * 100. WET – Shipments of Wet Material not Packed in Watertight Containers
 * 101. XPS – Priority Small Package
 *
 * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode Ontology
 */
#[Version('1.0.0')]
enum SpecialHandlingCode: string
{
    /**
     * Active Temperature Controlled System
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ACT Ontology
     */
    case ACT = 'ACT';

    /**
     * Aircraft on Ground
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#AOG Ontology
     */
    case AOG = 'AOG';

    /**
     * Goods Attached to Air Waybill
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ATT Ontology
     */
    case ATT = 'ATT';

    /**
     * Live Animal
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#AVI Ontology
     */
    case AVI = 'AVI';

    /**
     * Outsized
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#BIG Ontology
     */
    case BIG = 'BIG';

    /**
     * Bulk Unitization Programme, Shipper/Consignee Handled Unit
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#BUP Ontology
     */
    case BUP = 'BUP';

    /**
     * Cargo Aircraft Only
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#CAO Ontology
     */
    case CAO = 'CAO';

    /**
     * Cargo Attendant Accompanying Shipment
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#CAT Ontology
     */
    case CAT = 'CAT';

    /**
     * Cargo may be loaded in the passenger cabin
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#CIC Ontology
     */
    case CIC = 'CIC';

    /**
     * Cool Goods
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#COL Ontology
     */
    case COL = 'COL';

    /**
     * Company Mail
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#COM Ontology
     */
    case COM = 'COM';

    /**
     * Control Room Temperature +15°C to +25°C
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#CRT Ontology
     */
    case CRT = 'CRT';

    /**
     * Diplomatic Mail
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#DIP Ontology
     */
    case DIP = 'DIP';

    /**
     * e-freight Consignment with Accompanying Paper Documents
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#EAP Ontology
     */
    case EAP = 'EAP';

    /**
     * Foodstuffs
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#EAT Ontology
     */
    case EAT = 'EAT';

    /**
     * e-freight Consignment with No Accompanying Paper Documents
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#EAW Ontology
     */
    case EAW = 'EAW';

    /**
     * Lithium ion batteries excepted as per Section II of PI 965
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#EBI Ontology
     */
    case EBI = 'EBI';

    /**
     * Lithium metal batteries excepted as per Section II of PI 968
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#EBM Ontology
     */
    case EBM = 'EBM';

    /**
     * Consignment established with an electronically concluded cargo contract with no accompanying paper airwaybill
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ECC Ontology
     */
    case ECC = 'ECC';

    /**
     * Consignment established with a paper air waybill contract being printed under an e-AWB agreement
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ECP Ontology
     */
    case ECP = 'ECP';

    /**
     * Lithium Ion Batteries otherwise excepted from the IATA DGR
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ELI Ontology
     */
    case ELI = 'ELI';

    /**
     * Lithium Metal Batteries otherwise excepted from the IATA DGR
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ELM Ontology
     */
    case ELM = 'ELM';

    /**
     * Electronic Monitoring Devices on/in Cargo/Container
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#EMD Ontology
     */
    case EMD = 'EMD';

    /**
     * Extended Room Temperature +2°C to +25°C
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ERT Ontology
     */
    case ERT = 'ERT';

    /**
     * Undeveloped/Unexposed Film
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#FIL Ontology
     */
    case FIL = 'FIL';

    /**
     * Frozen Goods Subject to Veterinary/Phytosanitary Inspections
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#FRI Ontology
     */
    case FRI = 'FRI';

    /**
     * Frozen Goods
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#FRO Ontology
     */
    case FRO = 'FRO';

    /**
     * Hanging Garments
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#GOH Ontology
     */
    case GOH = 'GOH';

    /**
     * Heavy Cargo/150 kilograms and over per piece
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#HEA Ontology
     */
    case HEA = 'HEA';

    /**
     * Hatching Eggs
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#HEG Ontology
     */
    case HEG = 'HEG';

    /**
     * Human Remains in Coffin
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#HUM Ontology
     */
    case HUM = 'HUM';

    /**
     * Dry Ice
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ICE Ontology
     */
    case ICE = 'ICE';

    /**
     * Living Human Organs/Blood
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#LHO Ontology
     */
    case LHO = 'LHO';

    /**
     * License Required
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#LIC Ontology
     */
    case LIC = 'LIC';

    /**
     * Magnetized Material
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#MAG Ontology
     */
    case MAG = 'MAG';

    /**
     * Mail
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#MAL Ontology
     */
    case MAL = 'MAL';

    /**
     * Munitions of War
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#MUW Ontology
     */
    case MUW = 'MUW';

    /**
     * Cargo Has Not Been Secured Yet for Passenger or All-Cargo Aircraft
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#NSC Ontology
     */
    case NSC = 'NSC';

    /**
     * Non Stackable Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#NST Ontology
     */
    case NST = 'NST';

    /**
     * Newspapers, Magazines
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#NWP Ontology
     */
    case NWP = 'NWP';

    /**
     * Obnoxious Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#OBX Ontology
     */
    case OBX = 'OBX';

    /**
     * Overhang Item
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#OHG Ontology
     */
    case OHG = 'OHG';

    /**
     * Passenger and Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PAC Ontology
     */
    case PAC = 'PAC';

    /**
     * Hunting trophies, skin, hide and all articles made from or containing parts of species listed in the CITES (Convention on International Trade in Endangered Species) appendices
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PEA Ontology
     */
    case PEA = 'PEA';

    /**
     * Animal products for non-human consumption
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PEB Ontology
     */
    case PEB = 'PEB';

    /**
     * Flowers
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PEF Ontology
     */
    case PEF = 'PEF';

    /**
     * Meat
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PEM Ontology
     */
    case PEM = 'PEM';

    /**
     * Fruits and Vegetables
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PEP Ontology
     */
    case PEP = 'PEP';

    /**
     * Perishable Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PER Ontology
     */
    case PER = 'PER';

    /**
     * Fish/Seafood
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PES Ontology
     */
    case PES = 'PES';

    /**
     * Goods subject to phytosanitary inspections
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PHY Ontology
     */
    case PHY = 'PHY';

    /**
     * Pharmaceuticals
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PIL Ontology
     */
    case PIL = 'PIL';

    /**
     * Passive Insulated Packaging
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#PIP Ontology
     */
    case PIP = 'PIP';

    /**
     * Quick Ramp Transfer
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#QRT Ontology
     */
    case QRT = 'QRT';

    /**
     * Reserved Air Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RAC Ontology
     */
    case RAC = 'RAC';

    /**
     * Fully regulated lithium ion batteries (Class 9, UN 3480) as per Section IA and IB of PI 965
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RBI Ontology
     */
    case RBI = 'RBI';

    /**
     * Fully regulated lithium metal batteries (Class 9, UN 3090) as per Section IA and IB of PI 968
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RBM Ontology
     */
    case RBM = 'RBM';

    /**
     * Cryogenic Liquids
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RCL Ontology
     */
    case RCL = 'RCL';

    /**
     * Corrosive
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RCM Ontology
     */
    case RCM = 'RCM';

    /**
     * Explosives 1.3C
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RCX Ontology
     */
    case RCX = 'RCX';

    /**
     * Diagnostic Specimens
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RDS Ontology
     */
    case RDS = 'RDS';

    /**
     * Excepted Quantities of Dangerous Goods
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#REQ Ontology
     */
    case REQ = 'REQ';

    /**
     * To be reserved for normally forbidden Explosives, Divisions 1.1, 1.2, 1.3, 1.4F, 1.5 and 1.6
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#REX Ontology
     */
    case REX = 'REX';

    /**
     * Flammable Gas
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RFG Ontology
     */
    case RFG = 'RFG';

    /**
     * Flammable Liquid
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RFL Ontology
     */
    case RFL = 'RFL';

    /**
     * Flammable Solid
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RFS Ontology
     */
    case RFS = 'RFS';

    /**
     * Dangerous When Wet
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RFW Ontology
     */
    case RFW = 'RFW';

    /**
     * Explosives 1.3G
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RGX Ontology
     */
    case RGX = 'RGX';

    /**
     * Infectious Substance
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RIS Ontology
     */
    case RIS = 'RIS';

    /**
     * Fully Regulated Lithium Ion Batteries (Class 9)
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RLI Ontology
     */
    case RLI = 'RLI';

    /**
     * Fully Regulated Lithium Metal Batteries (Class 9)
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RLM Ontology
     */
    case RLM = 'RLM';

    /**
     * Miscellaneous Dangerous Goods
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RMD Ontology
     */
    case RMD = 'RMD';

    /**
     * Non-Flammable Non-Toxic Gas
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RNG Ontology
     */
    case RNG = 'RNG';

    /**
     * Organic Peroxide
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ROP Ontology
     */
    case ROP = 'ROP';

    /**
     * Oxidizer
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#ROX Ontology
     */
    case ROX = 'ROX';

    /**
     * Toxic Substance
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RPB Ontology
     */
    case RPB = 'RPB';

    /**
     * Toxic Gas
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RPG Ontology
     */
    case RPG = 'RPG';

    /**
     * Excepted Quantities of Radioactive Material
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RRE Ontology
     */
    case RRE = 'RRE';

    /**
     * Radioactive Material Category I-White
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RRW Ontology
     */
    case RRW = 'RRW';

    /**
     * Radioactive Material Categories II-Yellow and III-Yellow
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RRY Ontology
     */
    case RRY = 'RRY';

    /**
     * Polymeric Beads
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RSB Ontology
     */
    case RSB = 'RSB';

    /**
     * Spontaneously Combustible
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RSC Ontology
     */
    case RSC = 'RSC';

    /**
     * Explosives 1.4B
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RXB Ontology
     */
    case RXB = 'RXB';

    /**
     * Explosives 1.4C
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RXC Ontology
     */
    case RXC = 'RXC';

    /**
     * Explosives 1.4D
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RXD Ontology
     */
    case RXD = 'RXD';

    /**
     * Explosives 1.4E
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RXE Ontology
     */
    case RXE = 'RXE';

    /**
     * Explosives 1.4G
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RXG Ontology
     */
    case RXG = 'RXG';

    /**
     * Explosives 1.4S
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#RXS Ontology
     */
    case RXS = 'RXS';

    /**
     * Cargo Secure for All-Cargo Aircraft Only
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#SCO Ontology
     */
    case SCO = 'SCO';

    /**
     * Save Human Life
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#SHL Ontology
     */
    case SHL = 'SHL';

    /**
     * Secure for Passenger, All-Cargo and All-Mail Aircraft in Accordance with High Risk Requirements
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#SHR Ontology
     */
    case SHR = 'SHR';

    /**
     * Laboratory Animals
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#SPF Ontology
     */
    case SPF = 'SPF';

    /**
     * Cargo Secure for Passenger and All-Cargo Aircraft
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#SPX Ontology
     */
    case SPX = 'SPX';

    /**
     * Surface Transportation
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#SUR Ontology
     */
    case SUR = 'SUR';

    /**
     * Sporting Weapons
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#SWP Ontology
     */
    case SWP = 'SWP';

    /**
     * Valuable Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#VAL Ontology
     */
    case VAL = 'VAL';

    /**
     * Very Important Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#VIC Ontology
     */
    case VIC = 'VIC';

    /**
     * Volume
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#VOL Ontology
     */
    case VOL = 'VOL';

    /**
     * Vulnerable Cargo
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#VUN Ontology
     */
    case VUN = 'VUN';

    /**
     * Shipments of Wet Material not Packed in Watertight Containers
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#WET Ontology
     */
    case WET = 'WET';

    /**
     * Priority Small Package
     *
     * @link https://onerecord.iata.org/ns/code-lists/SpecialHandlingCode#XPS Ontology
     */
    case XPS = 'XPS';
}
