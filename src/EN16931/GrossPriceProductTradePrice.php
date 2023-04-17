<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\GrossPriceProductTradePrice\BasisQuantity;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

/**
 * BT-148-00.
 */
class GrossPriceProductTradePrice
{
    /**
     * BT-148.
     */
    private UnitPriceAmount $chargeAmount;

    /**
     * BT-149-1 & BT-150-1.
     */
    private ?BasisQuantity $basisQuantity;

    /**
     * BT-147-00.
     */
    private ?AppliedTradeAllowanceCharge $appliedTradeAllowanceCharge;

    public function __construct(float $chargeAmount)
    {
        $this->chargeAmount                = new UnitPriceAmount($chargeAmount);
        $this->basisQuantity               = null;
        $this->appliedTradeAllowanceCharge = null;
    }

    public function getChargeAmount(): float
    {
        return $this->chargeAmount->getValueRounded();
    }

    public function getBasisQuantity(): ?BasisQuantity
    {
        return $this->basisQuantity;
    }

    public function setBasisQuantity(?BasisQuantity $basisQuantity): void
    {
        $this->basisQuantity = $basisQuantity;
    }

    public function getAppliedTradeAllowanceCharge(): ?AppliedTradeAllowanceCharge
    {
        return $this->appliedTradeAllowanceCharge;
    }

    public function setAppliedTradeAllowanceCharge(?AppliedTradeAllowanceCharge $appliedTradeAllowanceCharge): void
    {
        $this->appliedTradeAllowanceCharge = $appliedTradeAllowanceCharge;
    }
}
