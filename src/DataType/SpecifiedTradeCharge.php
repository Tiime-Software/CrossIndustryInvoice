<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

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
    private ChargeIndicator $chargeChargeIndicator;

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

    public function __construct(float $actualAmount, CategoryTradeTax $categoryTradeTax)
    {
        $this->chargeChargeIndicator = new ChargeIndicator();
        $this->actualAmount          = new Amount($actualAmount);
        $this->categoryTradeTax      = $categoryTradeTax;
        $this->calculationPercentage = null;
        $this->basisAmount           = null;
        $this->reasonCode            = null;
        $this->reason                = null;
    }

    public function getChargeChargeIndicator(): ChargeIndicator
    {
        return $this->chargeChargeIndicator;
    }

    public function getCalculationPercentage(): ?float
    {
        return $this->calculationPercentage?->getValueRounded();
    }

    public function setCalculationPercentage(?Percentage $calculationPercentage): static
    {
        $this->calculationPercentage = $calculationPercentage;

        return $this;
    }

    public function getBasisAmount(): ?float
    {
        return $this->basisAmount?->getValueRounded();
    }

    public function setBasisAmount(?Amount $basisAmount): static
    {
        $this->basisAmount = $basisAmount;

        return $this;
    }

    public function getActualAmount(): float
    {
        return $this->actualAmount->getValueRounded();
    }

    public function getReasonCode(): ?ChargeReasonCode
    {
        return $this->reasonCode;
    }

    public function setReasonCode(?ChargeReasonCode $reasonCode): static
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

    public function getCategoryTradeTax(): CategoryTradeTax
    {
        return $this->categoryTradeTax;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTradeAllowanceCharge');

        $element->appendChild($this->chargeChargeIndicator->toXML($document));

        if ($this->calculationPercentage instanceof Percentage) {
            $element->appendChild($document->createElement('ram:CalculationPercent', (string) $this->calculationPercentage->getValueRounded()));
        }

        if ($this->basisAmount instanceof Amount) {
            $element->appendChild($document->createElement('ram:BasisAmount', (string) $this->basisAmount->getValueRounded()));
        }

        $element->appendChild($document->createElement('ram:ActualAmount', (string) $this->actualAmount->getValueRounded()));

        if ($this->reasonCode instanceof ChargeReasonCode) {
            $element->appendChild($document->createElement('ram:ReasonCode', $this->reasonCode->value));
        }

        if (\is_string($this->reason)) {
            $element->appendChild($document->createElement('ram:Reason', $this->reason));
        }

        $element->appendChild($this->categoryTradeTax->toXML($document));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        // todo
    }
}
