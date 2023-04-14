<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\CountryAlpha2Code;

/**
 * BT-159-00.
 */
class OriginTradeCountry
{
    /**
     * BT-159.
     */
    private ?CountryAlpha2Code $id;

    public function __construct()
    {
    }

    public function getId(): ?CountryAlpha2Code
    {
        return $this->id;
    }

    public function setId(?CountryAlpha2Code $id): void
    {
        $this->id = $id;
    }
}
