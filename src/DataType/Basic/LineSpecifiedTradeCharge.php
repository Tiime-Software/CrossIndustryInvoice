<?php

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\CrossIndustryInvoice\DataType\ChargeIndicator;
use Tiime\EN16931\DataType\ChargeReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-28.
 */
class LineSpecifiedTradeCharge
{
    protected const XML_NODE = 'ram:SpecifiedTradeAllowanceCharge';

    /**
     * BG-28-0.
     */
    private ChargeIndicator $chargeIndicator;

    /**
     * BT-141.
     */
    private Amount $actualAmount;

    /**
     * BT-145.
     */
    private ?ChargeReasonCode $reasonCode;

    /**
     * BT-144.
     */
    private ?string $reason;

    public function __construct(float $actualAmount)
    {
        $this->actualAmount    = new Amount($actualAmount);
        $this->chargeIndicator = new ChargeIndicator();
        $this->reasonCode      = null;
        $this->reason          = null;
    }

    public function getChargeIndicator(): ChargeIndicator
    {
        return $this->chargeIndicator;
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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->chargeIndicator->toXML($document));
        $currentNode->appendChild($document->createElement('ram:ActualAmount', (string) $this->actualAmount->getValueRounded()));

        if ($this->reasonCode instanceof ChargeReasonCode) {
            $currentNode->appendChild($document->createElement('ram:ReasonCode', $this->reasonCode->value));
        }

        if (\is_string($this->reason)) {
            $currentNode->appendChild($document->createElement('ram:Reason', $this->reason));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        // todo
    }
}
