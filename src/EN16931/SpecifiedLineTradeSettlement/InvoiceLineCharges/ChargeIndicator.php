<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\InvoiceLineCharges;

/**
 * BG-28-0.
 */
class ChargeIndicator
{
    /**
     * BG-28-1.
     */
    private bool $indicator;

    public function __construct()
    {
        $this->indicator = true;
    }

    public function getIndicator(): bool
    {
        return $this->indicator;
    }
}