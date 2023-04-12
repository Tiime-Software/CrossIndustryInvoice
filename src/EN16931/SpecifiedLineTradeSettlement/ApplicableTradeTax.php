<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement;

/**
 * BG-30
 */
class ApplicableTradeTax
{
    private string $typeCode;

    public function __construct()
    {
        $this->typeCode = "VAT";
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }
}