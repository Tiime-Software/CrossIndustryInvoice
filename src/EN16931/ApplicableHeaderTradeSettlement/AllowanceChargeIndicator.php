<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;

/**
 * BG-20-0.
 */
class AllowanceChargeIndicator
{
    /**
     * BG-20-1.
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
