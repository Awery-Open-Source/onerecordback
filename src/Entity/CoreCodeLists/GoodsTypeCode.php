<?php

namespace App\Entity\CoreCodeLists;

use App\Attribute\Version;

/**
 * Restricted code list referring to the CITES appendices
 * Source: CITES
 *
 * Options:
 * 1. I – Species included in Appendix I of CITES
 * 2. II – Species included in Appendix II of CITES
 * 3. III – Species included in Appendix III of CITES
 *
 * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeCode Ontology
 */
#[Version('1.0.0')]
enum GoodsTypeCode: string
{
    /**
     * Species included in Appendix I of CITES
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeCode#I Ontology
     */
    case I = 'I';

    /**
     * Species included in Appendix II of CITES
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeCode#II Ontology
     */
    case II = 'II';

    /**
     * Species included in Appendix III of CITES
     *
     * @link https://onerecord.iata.org/ns/code-lists/GoodsTypeCode#III Ontology
     */
    case III = 'III';
}
