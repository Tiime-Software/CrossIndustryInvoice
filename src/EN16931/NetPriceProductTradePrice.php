<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\NetPriceProductTradePrice\BasisQuantity;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

/**
 * BT-146-00.
 */
class NetPriceProductTradePrice
{
    /**
     * BT-146.
     */
    private UnitPriceAmount $chargeAmount;

    /**
     * BT-149 & BT-150.
     */
    private ?BasisQuantity $basisQuantity;

    public function __construct(float $chargeAmount)
    {
        $this->chargeAmount  = new UnitPriceAmount($chargeAmount);
        $this->basisQuantity = null;
    }

    public function getChargeAmount(): UnitPriceAmount
    {
        return $this->chargeAmount;
    }

    public function getBasisQuantity(): ?BasisQuantity
    {
        return $this->basisQuantity;
    }

    public function setBasisQuantity(?BasisQuantity $basisQuantity): void
    {
        $this->basisQuantity = $basisQuantity;
    }
}
