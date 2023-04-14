<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;

/**
 * BG-21-0.
 */
class ChargeChargeIndicator
{
    /**
     * BG-21-1.
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
