<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Open code list extended from cXML code list 1.48 Measurement Unit Code and based on UNECE Rec. 20
 * Source: UNECE Rec. 20 Rev. 17e-2021
 *
 * Options:
 * 1. BQL – Becquerel
 * 2. CEL – Degree Celsius
 * 3. CGM – Centigram
 * 4. CLT – Centilitre
 * 5. CMQ – Cubic Centimetre
 * 6. CMT – Centimetre
 * 7. CUR – Curie
 * 8. DLT – Decilitre
 * 9. DMT – Decimetre
 * 10. FAH – Degree Fahrenheit
 * 11. FOT – Foot
 * 12. FTQ – Cubic Foot
 * 13. GIA – Gill (11.8294 CM3)
 * 14. GII – Gigabecquerel GBQ Gill (0.142065 DM3)
 * 15. GLI – Gallon (4.546092 DM3)
 * 16. GLL – Liquid Gallon (3.78541 DM3)
 * 17. GRM – Gram
 * 18. INH – Inch
 * 19. INQ – Cubic Inch
 * 20. KBQ – Kilobecquerel
 * 21. KEL – Kelvin
 * 22. KGM – Kilogram
 * 23. LBR – Pound UK, US (0.45359237 KGM)
 * 24. LTR – Litre (1 DM3)
 * 25. MBQ – Megabecquerel
 * 26. MGM – Milligram
 * 27. MLT – Millilitre
 * 28. MMT – Millimetre
 * 29. MTQ – Cubic Metre
 * 30. MTR – Metre
 * 31. NDA – No Dimensions Available
 * 32. ONZ – Ounce UK, US (28.949523 GRM)
 * 33. OZA – Fluid Ounce (29.5795 CM3)
 * 34. OZI – Fluid Ounce (28.413 CM3)
 * 35. PTI – Pint (0.568262 DM3)
 * 36. PTL – Liquid Pint (0.473176 DM3)
 * 37. QTI – Quart (1.136523 DM3)
 * 38. QTL – Liquid Quart (0.946353 DM3)
 * 39. TBQ – Terabecquerel
 * 40. YRD – Yard (0.9144 MTR)
 *
 * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode Ontology
 */
#[Version('1.0.0')]
enum MeasurementUnitCode: string
{
    /**
     * Becquerel
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#BQL Ontology
     */
    case BQL = 'BQL';

    /**
     * Degree Celsius
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#CEL Ontology
     */
    case CEL = 'CEL';

    /**
     * Centigram
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#CGM Ontology
     */
    case CGM = 'CGM';

    /**
     * Centilitre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#CLT Ontology
     */
    case CLT = 'CLT';

    /**
     * Cubic Centimetre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#CMQ Ontology
     */
    case CMQ = 'CMQ';

    /**
     * Centimetre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#CMT Ontology
     */
    case CMT = 'CMT';

    /**
     * Curie
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#CUR Ontology
     */
    case CUR = 'CUR';

    /**
     * Decilitre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#DLT Ontology
     */
    case DLT = 'DLT';

    /**
     * Decimetre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#DMT Ontology
     */
    case DMT = 'DMT';

    /**
     * Degree Fahrenheit
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#FAH Ontology
     */
    case FAH = 'FAH';

    /**
     * Foot
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#FOT Ontology
     */
    case FOT = 'FOT';

    /**
     * Cubic Foot
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#FTQ Ontology
     */
    case FTQ = 'FTQ';

    /**
     * Gill (11.8294 CM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#GIA Ontology
     */
    case GIA = 'GIA';

    /**
     * Gigabecquerel GBQ Gill (0.142065 DM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#GII Ontology
     */
    case GII = 'GII';

    /**
     * Gallon (4.546092 DM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#GLI Ontology
     */
    case GLI = 'GLI';

    /**
     * Liquid Gallon (3.78541 DM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#GLL Ontology
     */
    case GLL = 'GLL';

    /**
     * Gram
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#GRM Ontology
     */
    case GRM = 'GRM';

    /**
     * Inch
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#INH Ontology
     */
    case INH = 'INH';

    /**
     * Cubic Inch
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#INQ Ontology
     */
    case INQ = 'INQ';

    /**
     * Kilobecquerel
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#KBQ Ontology
     */
    case KBQ = 'KBQ';

    /**
     * Kelvin
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#KEL Ontology
     */
    case KEL = 'KEL';

    /**
     * Kilogram
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#KGM Ontology
     */
    case KGM = 'KGM';

    /**
     * Pound UK, US (0.45359237 KGM)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#LBR Ontology
     */
    case LBR = 'LBR';

    /**
     * Litre (1 DM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#LTR Ontology
     */
    case LTR = 'LTR';

    /**
     * Megabecquerel
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#MBQ Ontology
     */
    case MBQ = 'MBQ';

    /**
     * Milligram
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#MGM Ontology
     */
    case MGM = 'MGM';

    /**
     * Millilitre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#MLT Ontology
     */
    case MLT = 'MLT';

    /**
     * Millimetre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#MMT Ontology
     */
    case MMT = 'MMT';

    /**
     * Cubic Metre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#MTQ Ontology
     */
    case MTQ = 'MTQ';

    /**
     * Metre
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#MTR Ontology
     */
    case MTR = 'MTR';

    /**
     * No Dimensions Available
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#NDA Ontology
     */
    case NDA = 'NDA';

    /**
     * Ounce UK, US (28.949523 GRM)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#ONZ Ontology
     */
    case ONZ = 'ONZ';

    /**
     * Fluid Ounce (29.5795 CM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#OZA Ontology
     */
    case OZA = 'OZA';

    /**
     * Fluid Ounce (28.413 CM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#OZI Ontology
     */
    case OZI = 'OZI';

    /**
     * Pint (0.568262 DM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#PTI Ontology
     */
    case PTI = 'PTI';

    /**
     * Liquid Pint (0.473176 DM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#PTL Ontology
     */
    case PTL = 'PTL';

    /**
     * Quart (1.136523 DM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#QTI Ontology
     */
    case QTI = 'QTI';

    /**
     * Liquid Quart (0.946353 DM3)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#QTL Ontology
     */
    case QTL = 'QTL';

    /**
     * Terabecquerel
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#TBQ Ontology
     */
    case TBQ = 'TBQ';

    /**
     * Yard (0.9144 MTR)
     *
     * @link https://onerecord.iata.org/ns/code-lists/MeasurementUnitCode#YRD Ontology
     */
    case YRD = 'YRD';
}
