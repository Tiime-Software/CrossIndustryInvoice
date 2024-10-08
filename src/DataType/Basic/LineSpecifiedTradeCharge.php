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
    protected const string XML_NODE = 'ram:SpecifiedTradeAllowanceCharge';

    /**
     * BG-28-0.
     */
    protected ChargeIndicator $chargeIndicator;

    /**
     * BT-141.
     */
    protected Amount $actualAmount;

    /**
     * BT-145.
     */
    protected ?ChargeReasonCode $reasonCode;

    /**
     * BT-144.
     */
    protected ?string $reason;

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

    public function getActualAmount(): Amount
    {
        return $this->actualAmount;
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
        $currentNode->appendChild($document->createElement('ram:ActualAmount', $this->actualAmount->getFormattedValueRounded()));

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
        $lineSpecifiedTradeChargeElements = $xpath->query(\sprintf('./%s[ram:ChargeIndicator/udt:Indicator[text() = \'true\']]', self::XML_NODE), $currentElement);

        if (0 === $lineSpecifiedTradeChargeElements->count()) {
            return [];
        }

        $lineSpecifiedTradeCharges = [];

        foreach ($lineSpecifiedTradeChargeElements as $lineSpecifiedTradeChargeElement) {
            $actualAmountElements = $xpath->query('./ram:ActualAmount', $lineSpecifiedTradeChargeElement);
            $reasonCodeElements   = $xpath->query('./ram:ReasonCode', $lineSpecifiedTradeChargeElement);
            $reasonElements       = $xpath->query('./ram:Reason', $lineSpecifiedTradeChargeElement);

            if (1 !== $actualAmountElements->count()) {
                throw new \Exception('Malformed');
            }

            if ($reasonCodeElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            if ($reasonElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            $actualAmount = $actualAmountElements->item(0)->nodeValue;
            // Look if node is well constructed, already created in the constructor
            ChargeIndicator::fromXML($xpath, $lineSpecifiedTradeChargeElement);

            $lineSpecifiedTradeCharge = new self((float) $actualAmount);

            if (1 === $reasonCodeElements->count()) {
                $reasonCode = ChargeReasonCode::tryFrom($reasonCodeElements->item(0)->nodeValue);

                if (null === $reasonCode) {
                    throw new \Exception('Wrong ReasonCode');
                }

                $lineSpecifiedTradeCharge->setReasonCode($reasonCode);
            }

            if (1 === $reasonElements->count()) {
                $lineSpecifiedTradeCharge->setReason($reasonElements->item(0)->nodeValue);
            }

            $lineSpecifiedTradeCharges[] = $lineSpecifiedTradeCharge;
        }

        return $lineSpecifiedTradeCharges;
    }
}
