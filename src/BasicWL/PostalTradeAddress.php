<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\CountryAlpha2Code;

/**
 * BG-5.
 */
class PostalTradeAddress
{
    /**
     * BT-38.
     */
    private ?string $postcodeCode;

    /**
     * BT-35.
     */
    private ?string $line1;

    /**
     * BT-36.
     */
    private ?string $line2;

    /**
     * BT-162.
     */
    private ?string $line3;

    /**
     * BT-37.
     */
    private ?string $cityName;

    /**
     * BT-40.
     */
    private CountryAlpha2Code $countryId;

    /**
     * BT-39.
     */
    private ?string $countrySubDivisionName;
}
