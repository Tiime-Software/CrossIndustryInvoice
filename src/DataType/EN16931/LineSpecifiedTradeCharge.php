<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\EN16931\BusinessTermsGroup\InvoiceLineCharge;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-28.
 */
class LineSpecifiedTradeCharge extends \Tiime\CrossIndustryInvoice\DataType\Basic\LineSpecifiedTradeCharge
{
    /**
     * BT-143.
     */
    private ?Percentage $calculationPercent;

    /**
     * BT-142.
     */
    private ?Amount $basisAmount;

    public function __construct(float $actualAmount)
    {
        parent::__construct($actualAmount);
        $this->calculationPercent = null;
        $this->basisAmount        = null;
    }

    public function getCalculationPercent(): ?float
    {
        return $this->calculationPercent->getValueRounded();
    }

    public function setCalculationPercent(?float $calculationPercent): static
    {
        $this->calculationPercent = \is_float($calculationPercent) ? new Percentage($calculationPercent) : null;

        return $this;
    }

    public function getBasisAmount(): ?float
    {
        return $this->basisAmount?->getValueRounded();
    }

    public function setBasisAmount(?float $basisAmount): static
    {
        $this->basisAmount = \is_float($basisAmount) ? new Amount($basisAmount) : null;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:SpecifiedTradeAllowanceCharge');

        $currentNode->appendChild($this->getChargeIndicator()->toXML($document));

        if (null !== $this->calculationPercent) {
            $currentNode->appendChild($document->createElement('ram:CalculationPercent', (string) $this->calculationPercent->getValueRounded()));
        }

        if (null !== $this->basisAmount) {
            $currentNode->appendChild($document->createElement('ram:BasisAmount', (string) $this->basisAmount->getValueRounded()));
        }

        $currentNode->appendChild($document->createElement('ram:ActualAmount', (string) $this->getActualAmount()));

        if (null !== $this->getReasonCode()) {
            $currentNode->appendChild($document->createElement('ram:ReasonCode', $this->getReasonCode()->value));
        }

        if (null !== $this->getReason()) {
            $currentNode->appendChild($document->createElement('ram:Reason', $this->getReason()));
        }

        return $currentNode;
    }

    public static function fromEN16931(InvoiceLineCharge $charge): static
    {
        return (new self($charge->getAmount()))
            ->setCalculationPercent($charge->getPercentage())
            ->setBasisAmount($charge->getBaseAmount())
            ->setReasonCode($charge->getReasonCode())
            ->setReason($charge->getReason());
    }
}
