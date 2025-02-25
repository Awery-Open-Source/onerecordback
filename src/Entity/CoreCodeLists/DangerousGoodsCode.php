<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 1.14 Dangerous Goods Codes
 * Source: Dangerous Goods Regulations, 46th Edition
 *
 * Options:
 * 1. CAO – Cargo Aircraft Only
 * 2. EBI – Lithium ion batteries excepted as per Section II of PI 965
 * 3. EBM – Lithium metal batteries excepted as per Section II of PI 968
 * 4. ELI – Lithium Ion Batteries otherwise excepted from the IATA DGR
 * 5. ELM – Lithium Metal Batteries otherwise excepted from the IATA DGR
 * 6. ICE – Dry Ice
 * 7. MAG – Magnetized Material
 * 8. RBI – Fully regulated lithium ion batteries (Class 9, UN 3480) as per Section IA and IB of PI 965
 * 9. RBM – Fully regulated lithium metal batteries (Class 9, UN 3090) as per Section IA and IB of PI 968
 * 10. RCL – Cryogenic Liquids
 * 11. RCM – Corrosive
 * 12. RCX – Explosives 1.3C
 * 13. REX – To be reserved for normally forbidden Explosives, Divisions 1.1, 1.2, 1.3, 1.4F, 1.5 and 1.6
 * 14. RFG – Flammable Gas
 * 15. RFL – Flammable Liquid
 * 16. RFS – Flammable Solid
 * 17. RFW – Dangerous When Wet
 * 18. RGX – Explosives 1.3G
 * 19. RIS – Infectious Substance
 * 20. RLI – Fully Regulated Lithium Ion Batteries (Class 9)
 * 21. RLM – Fully Regulated Lithium Metal Batteries (Class 9)
 * 22. RMD – Miscellaneous Dangerous Goods
 * 23. RNG – Non-Flammable Non-Toxic Gas
 * 24. ROP – Organic Peroxide
 * 25. ROX – Oxidizer
 * 26. RPB – Toxic Substance
 * 27. RPG – Toxic Gas
 * 28. RRW – Radioactive Material Category I-White
 * 29. RRY – Radioactive Material Categories II-Yellow and III-Yellow
 * 30. RSB – Polymeric Beads
 * 31. RSC – Spontaneously Combustible
 * 32. RXB – Explosives 1.4B
 * 33. RXC – Explosives 1.4C
 * 34. RXD – Explosives 1.4D
 * 35. RXE – Explosives 1.4E
 * 36. RXG – Explosives 1.4G
 * 37. RXS – Explosives 1.4S
 *
 * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode Ontology
 */
#[Version('1.0.0')]
enum DangerousGoodsCode: string
{
    /**
     * Cargo Aircraft Only
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#CAO Ontology
     */
    case CAO = 'CAO';

    /**
     * Lithium ion batteries excepted as per Section II of PI 965
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#EBI Ontology
     */
    case EBI = 'EBI';

    /**
     * Lithium metal batteries excepted as per Section II of PI 968
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#EBM Ontology
     */
    case EBM = 'EBM';

    /**
     * Lithium Ion Batteries otherwise excepted from the IATA DGR
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#ELI Ontology
     */
    case ELI = 'ELI';

    /**
     * Lithium Metal Batteries otherwise excepted from the IATA DGR
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#ELM Ontology
     */
    case ELM = 'ELM';

    /**
     * Dry Ice
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#ICE Ontology
     */
    case ICE = 'ICE';

    /**
     * Magnetized Material
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#MAG Ontology
     */
    case MAG = 'MAG';

    /**
     * Fully regulated lithium ion batteries (Class 9, UN 3480) as per Section IA and IB of PI 965
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RBI Ontology
     */
    case RBI = 'RBI';

    /**
     * Fully regulated lithium metal batteries (Class 9, UN 3090) as per Section IA and IB of PI 968
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RBM Ontology
     */
    case RBM = 'RBM';

    /**
     * Cryogenic Liquids
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RCL Ontology
     */
    case RCL = 'RCL';

    /**
     * Corrosive
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RCM Ontology
     */
    case RCM = 'RCM';

    /**
     * Explosives 1.3C
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RCX Ontology
     */
    case RCX = 'RCX';

    /**
     * To be reserved for normally forbidden Explosives, Divisions 1.1, 1.2, 1.3, 1.4F, 1.5 and 1.6
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#REX Ontology
     */
    case REX = 'REX';

    /**
     * Flammable Gas
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RFG Ontology
     */
    case RFG = 'RFG';

    /**
     * Flammable Liquid
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RFL Ontology
     */
    case RFL = 'RFL';

    /**
     * Flammable Solid
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RFS Ontology
     */
    case RFS = 'RFS';

    /**
     * Dangerous When Wet
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RFW Ontology
     */
    case RFW = 'RFW';

    /**
     * Explosives 1.3G
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RGX Ontology
     */
    case RGX = 'RGX';

    /**
     * Infectious Substance
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RIS Ontology
     */
    case RIS = 'RIS';

    /**
     * Fully Regulated Lithium Ion Batteries (Class 9)
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RLI Ontology
     */
    case RLI = 'RLI';

    /**
     * Fully Regulated Lithium Metal Batteries (Class 9)
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RLM Ontology
     */
    case RLM = 'RLM';

    /**
     * Miscellaneous Dangerous Goods
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RMD Ontology
     */
    case RMD = 'RMD';

    /**
     * Non-Flammable Non-Toxic Gas
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RNG Ontology
     */
    case RNG = 'RNG';

    /**
     * Organic Peroxide
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#ROP Ontology
     */
    case ROP = 'ROP';

    /**
     * Oxidizer
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#ROX Ontology
     */
    case ROX = 'ROX';

    /**
     * Toxic Substance
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RPB Ontology
     */
    case RPB = 'RPB';

    /**
     * Toxic Gas
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RPG Ontology
     */
    case RPG = 'RPG';

    /**
     * Radioactive Material Category I-White
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RRW Ontology
     */
    case RRW = 'RRW';

    /**
     * Radioactive Material Categories II-Yellow and III-Yellow
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RRY Ontology
     */
    case RRY = 'RRY';

    /**
     * Polymeric Beads
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RSB Ontology
     */
    case RSB = 'RSB';

    /**
     * Spontaneously Combustible
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RSC Ontology
     */
    case RSC = 'RSC';

    /**
     * Explosives 1.4B
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RXB Ontology
     */
    case RXB = 'RXB';

    /**
     * Explosives 1.4C
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RXC Ontology
     */
    case RXC = 'RXC';

    /**
     * Explosives 1.4D
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RXD Ontology
     */
    case RXD = 'RXD';

    /**
     * Explosives 1.4E
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RXE Ontology
     */
    case RXE = 'RXE';

    /**
     * Explosives 1.4G
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RXG Ontology
     */
    case RXG = 'RXG';

    /**
     * Explosives 1.4S
     *
     * @link https://onerecord.iata.org/ns/code-lists/DangerousGoodsCode#RXS Ontology
     */
    case RXS = 'RXS';
}
