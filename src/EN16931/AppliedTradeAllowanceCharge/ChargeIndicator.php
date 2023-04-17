<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\AppliedTradeAllowanceCharge;

/**
 * BT-147-01.
 */
class ChargeIndicator
{
    /**
     * BT-147-02.
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
