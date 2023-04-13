<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\InvoiceLineCharges;

use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-28.
 */
class SpecifiedTradeAllowanceCharge
{
    /**
     * BG-28-0.
     */
    private ChargeIndicator $chargeIndicator;

    /**
     * BT-143.
     */
    private ?Percentage $calculationPercent;

    /**
     * BT-142.
     */
    private ?Amount $basisAmount;

    /**
     * BT-141.
     */
    private Amount $actualAmount;

    /**
     * BT-145.
     */
    private ?AllowanceReasonCode $reasonCode;

    /**
     * BT-144.
     */
    private ?string $reason;

    public function __construct(float $actualAmount)
    {
        $this->actualAmount    = new Amount($actualAmount);
        $this->chargeIndicator = new ChargeIndicator();
    }

    public function getChargeIndicator(): ChargeIndicator
    {
        return $this->chargeIndicator;
    }

    public function getCalculationPercent(): ?float
    {
        return $this->calculationPercent?->getValueRounded();
    }

    public function setCalculationPercent(?float $calculationPercent): void
    {
        $this->calculationPercent = \is_float($calculationPercent) ? new Percentage($calculationPercent) : null;
    }

    public function getBasisAmount(): ?float
    {
        return $this->basisAmount?->getValueRounded();
    }

    public function setBasisAmount(?float $basisAmount): void
    {
        $this->basisAmount = \is_float($basisAmount) ? new Amount($basisAmount) : null;
    }

    public function getActualAmount(): float
    {
        return $this->actualAmount->getValueRounded();
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
