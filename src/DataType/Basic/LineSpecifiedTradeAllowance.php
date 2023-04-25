<?php

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\CrossIndustryInvoice\DataType\AllowanceIndicator;
use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-27.
 */
class LineSpecifiedTradeAllowance
{
    /**
     * BG-27-0 & BG-27-1.
     */
    private AllowanceIndicator $chargeIndicator;

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
        $this->chargeIndicator = new AllowanceIndicator();
        $this->reasonCode      = null;
        $this->reason          = null;
    }

    public function getChargeIndicator(): AllowanceIndicator
    {
        return $this->chargeIndicator;
    }

    public function getActualAmount(): float
    {
        return $this->actualAmount->getValueRounded();
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
        $currentNode = $document->createElement('ram:SpecifiedTradeAllowanceCharge');

        $currentNode->appendChild($this->chargeIndicator->toXML($document));

        $currentNode->appendChild($document->createElement('ram:ActualAmount', (string) $this->actualAmount->getValueRounded()));

        if (null !== $this->reasonCode) {
            $currentNode->appendChild($document->createElement('ram:ReasonCode', $this->reasonCode->value));
        }

        if (null !== $this->reason) {
            $currentNode->appendChild($document->createElement('ram:Reason', $this->reason));
        }

        return $currentNode;
    }
}
