<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\InvoiceLineAllowances;

use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-27.
 */
class SpecifiedTradeAllowance
{
    /**
     * BG-27-0.
     */
    private ChargeIndicator $chargeIndicator;

    /**
     * BT-138.
     */
    private ?Percentage $calculationPercent;

    /**
     * BT-137.
     */
    private ?Amount $basisAmount;

    /**
     * BT-136.
     */
    private Amount $actualAmount;

    /**
     * BT-140.
     */
    private ?AllowanceReasonCode $reasonCode;

    /**
     * BT-139.
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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTradeAllowanceCharge');

        $element->appendChild($this->chargeIndicator->toXML($document));

        if ($this->calculationPercent instanceof Percentage) {
            $element->appendChild($document->createElement('ram:CalculationPercent', (string) $this->calculationPercent->getValueRounded()));
        }

        if ($this->basisAmount instanceof Amount) {
            $element->appendChild($document->createElement('ram:BasisAmount', (string) $this->basisAmount->getValueRounded()));
        }

        $element->appendChild($document->createElement('ram:ActualAmount', (string) $this->actualAmount->getValueRounded()));

        if ($this->reasonCode instanceof AllowanceReasonCode) {
            $element->appendChild($document->createElement('ram:ReasonCode', $this->reasonCode->value));
        }

        if (\is_string($this->reason)) {
            $element->appendChild($document->createElement('ram:Reason', $this->reason));
        }

        return $element;
    }
}
