<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;

use Tiime\CrossIndustryInvoice\DataType\CategoryTradeTax;
use Tiime\CrossIndustryInvoice\DataType\ChargeChargeIndicator;
use Tiime\EN16931\DataType\ChargeReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-21.
 */
class SpecifiedTradeCharge
{
    /**
     * BG-21-0.
     */
    private ChargeChargeIndicator $chargeChargeIndicator;

    /**
     * BT-101.
     */
    private ?Percentage $calculationPercentage;

    /**
     * BT-100.
     */
    private ?Amount $basisAmount;

    /**
     * BT-99.
     */
    private Amount $actualAmount;

    /**
     * BT-105.
     */
    private ?ChargeReasonCode $reasonCode;

    /**
     * BT-104.
     */
    private ?string $reason;

    /**
     * BT-102-00.
     */
    private CategoryTradeTax $categoryTradeTax;

    public function __construct(Amount $actualAmount, CategoryTradeTax $categoryTradeTax)
    {
        $this->chargeChargeIndicator = new ChargeChargeIndicator();
        $this->actualAmount          = $actualAmount;
        $this->categoryTradeTax      = $categoryTradeTax;
        $this->calculationPercentage = null;
        $this->basisAmount           = null;
        $this->reasonCode            = null;
        $this->reason                = null;
    }

    public function getChargeChargeIndicator(): ChargeChargeIndicator
    {
        return $this->chargeChargeIndicator;
    }

    public function getCalculationPercentage(): ?Percentage
    {
        return $this->calculationPercentage;
    }

    public function setCalculationPercentage(?Percentage $calculationPercentage): void
    {
        $this->calculationPercentage = $calculationPercentage;
    }

    public function getBasisAmount(): ?Amount
    {
        return $this->basisAmount;
    }

    public function setBasisAmount(?Amount $basisAmount): void
    {
        $this->basisAmount = $basisAmount;
    }

    public function getActualAmount(): Amount
    {
        return $this->actualAmount;
    }

    public function getReasonCode(): ?ChargeReasonCode
    {
        return $this->reasonCode;
    }

    public function setReasonCode(?ChargeReasonCode $reasonCode): void
    {
        $this->reasonCode = $reasonCode;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): void
    {
        $this->reason = $reason;
    }

    public function getCategoryTradeTax(): CategoryTradeTax
    {
        return $this->categoryTradeTax;
    }
}
