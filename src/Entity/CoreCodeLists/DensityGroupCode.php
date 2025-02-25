<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list corresponding to cXML code list 2 Density Group Codes
 *
 * Options:
 * 1. 0 – 160kg per mc or 10 lbs per cf
 * 2. 1 – 300 kg per mc or 18.6 lbs per cf
 * 3. 10 – 950 kg per mc or 59.3 lbs per cf
 * 4. 2 – 90 kg per mc or 5.6 lbs per cf
 * 5. 3 – 120 kg per mc or 7.5 lbs per cf
 * 6. 4 – 220 kg per mc or 13.8 lbs per cf
 * 7. 5 – 60 kg per mc or 3.8 lbs per cf
 * 8. 6 – 250 kg per mc or 15.6 lbs per cf
 * 9. 8 – 400 kg per mc or 25 lbs per cf
 * 10. 9 – 600 kg per mc or 37.5 lbs per cf
 *
 * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode Ontology
 */
#[Version('1.0.0')]
enum DensityGroupCode: string
{
    /**
     * 160kg per mc or 10 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#0 Ontology
     */
    case ZERO = '0';

    /**
     * 300 kg per mc or 18.6 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#1 Ontology
     */
    case ONE = '1';

    /**
     * 950 kg per mc or 59.3 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#10 Ontology
     */
    case TEN = '10';

    /**
     * 90 kg per mc or 5.6 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#2 Ontology
     */
    case TWO = '2';

    /**
     * 120 kg per mc or 7.5 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#3 Ontology
     */
    case THREE = '3';

    /**
     * 220 kg per mc or 13.8 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#4 Ontology
     */
    case FOUR = '4';

    /**
     * 60 kg per mc or 3.8 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#5 Ontology
     */
    case FIVE = '5';

    /**
     * 250 kg per mc or 15.6 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#6 Ontology
     */
    case SIX = '6';

    /**
     * 400 kg per mc or 25 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#8 Ontology
     */
    case EIGHT = '8';

    /**
     * 600 kg per mc or 37.5 lbs per cf
     *
     * @link https://onerecord.iata.org/ns/code-lists/DensityGroupCode#9 Ontology
     */
    case NINE = '9';
}
