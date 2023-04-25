<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

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
    private AllowanceIndicator $allowanceChargeIndicator;

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
    private CategoryTradeTax $allowanceCategoryTradeTax;

    public function __construct(float $actualAmount, CategoryTradeTax $allowanceCategoryTradeTax)
    {
        $this->allowanceChargeIndicator  = new AllowanceIndicator();
        $this->actualAmount              = new Amount($actualAmount);
        $this->allowanceCategoryTradeTax = $allowanceCategoryTradeTax;
        $this->calculationPercent        = null;
        $this->basisAmount               = null;
        $this->reasonCode                = null;
        $this->reason                    = null;
    }

    public function getAllowanceChargeIndicator(): AllowanceIndicator
    {
        return $this->allowanceChargeIndicator;
    }

    public function getActualAmount(): float
    {
        return $this->actualAmount->getValueRounded();
    }

    public function getAllowanceCategoryTradeTax(): CategoryTradeTax
    {
        return $this->allowanceCategoryTradeTax;
    }

    public function getCalculationPercent(): ?float
    {
        return $this->calculationPercent?->getValueRounded();
    }

    public function setCalculationPercent(?float $calculationPercent): static
    {
        $this->calculationPercent = \is_float($calculationPercent) ? new Percentage($calculationPercent) : null;

        return $this;
    }

    public function getBasisAmount(): ?Amount
    {
        return $this->basisAmount;
    }

    public function setBasisAmount(?float $basisAmount): static
    {
        $this->basisAmount = \is_float($basisAmount) ? new Amount($basisAmount) : null;

        return $this;
    }

    public function getReasonCode(): ?AllowanceReasonCode
    {
        return $this->reasonCode;
    }

    public function setReasonCode(?AllowanceReasonCode $reasonCode): static
    {
        $this->reasonCode = $reasonCode;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTradeAllowanceCharge');

        $element->appendChild($this->allowanceChargeIndicator->toXML($document));

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

        $element->appendChild($this->allowanceCategoryTradeTax->toXML($document));

        return $element;
    }
}
