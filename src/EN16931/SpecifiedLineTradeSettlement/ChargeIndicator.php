<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement;

/**
 * BG-27-0.
 */
class ChargeIndicator
{
    /**
     * BG-27-1.
     */
    private bool $indicator;

    public function __construct()
    {
        $this->indicator = false;
    }

    public function getIndicator(): bool
    {
        return $this->indicator;
    }
}
