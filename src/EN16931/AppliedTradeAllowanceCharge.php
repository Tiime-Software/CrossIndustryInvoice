<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\AppliedTradeAllowanceCharge\ChargeIndicator;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

/**
 * BT-147-00.
 */
class AppliedTradeAllowanceCharge
{
    /**
     * BT-147-01.
     */
    private ChargeIndicator $chargeIndicator;

    /**
     * BT-147.
     */
    private UnitPriceAmount $actualAmount;

    public function __construct(float $actualAmount)
    {
        $this->chargeIndicator = new ChargeIndicator();
        $this->actualAmount    = new UnitPriceAmount($actualAmount);
    }

    public function getChargeIndicator(): ChargeIndicator
    {
        return $this->chargeIndicator;
    }

    public function getActualAmount(): float
    {
        return $this->actualAmount->getValueRounded();
    }
}
