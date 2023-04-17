<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;

use Tiime\CrossIndustryInvoice\DataType\AllowanceChargeIndicator;
use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-20.
 */
class SpecifiedTradeAllowance
{
    /**
     * BG-20-0.
     */
    private AllowanceChargeIndicator $allowanceChargeIndicator;

    /**
     * BT-94.
     */
    private ?Percentage $calculationPercent;

    /**
     * BT-93.
     */
    private ?Amount $basisAmount;

    /**
     * BT-92.
     */
    private Amount $actualAmount;

    /**
     * BT-98.
     */
    private ?AllowanceReasonCode $reasonCode;

    /**
     * BT-97.
     */
    private ?string $reason;

    /**
     * BT-95-00.
     */
    private AllowanceCategoryTradeTax $allowanceCategoryTradeTax;

    public function __construct(Amount $actualAmount, AllowanceCategoryTradeTax $allowanceCategoryTradeTax)
    {
        $this->allowanceChargeIndicator  = new AllowanceChargeIndicator();
        $this->actualAmount              = $actualAmount;
        $this->allowanceCategoryTradeTax = $allowanceCategoryTradeTax;
        $this->calculationPercent        = null;
        $this->basisAmount               = null;
        $this->reasonCode                = null;
        $this->reason                    = null;
    }

    public function getAllowanceChargeIndicator(): AllowanceChargeIndicator
    {
        return $this->allowanceChargeIndicator;
    }

    public function getActualAmount(): Amount
    {
        return $this->actualAmount;
    }

    public function getAllowanceCategoryTradeTax(): AllowanceCategoryTradeTax
    {
        return $this->allowanceCategoryTradeTax;
    }

    public function getCalculationPercent(): ?Percentage
    {
        return $this->calculationPercent;
    }

    public function setCalculationPercent(?Percentage $calculationPercent): void
    {
        $this->calculationPercent = $calculationPercent;
    }

    public function getBasisAmount(): ?Amount
    {
        return $this->basisAmount;
    }

    public function setBasisAmount(?Amount $basisAmount): void
    {
        $this->basisAmount = $basisAmount;
    }

    public function getReasonCode(): ?AllowanceReasonCode
    {
        return $this->reasonCode;
    }

    public function setReasonCode(?AllowanceReasonCode $reasonCode): void
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
}
