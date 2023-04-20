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
    private CategoryTradeTax $allowanceCategoryTradeTax;

    public function __construct(Amount $actualAmount, CategoryTradeTax $allowanceCategoryTradeTax)
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

    public function getAllowanceCategoryTradeTax(): CategoryTradeTax
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
