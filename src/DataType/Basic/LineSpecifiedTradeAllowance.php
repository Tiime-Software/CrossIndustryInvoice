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
    protected const XML_NODE = 'ram:SpecifiedTradeAllowanceCharge';

    /**
     * BG-27-0 & BG-27-1.
     */
    protected AllowanceIndicator $chargeIndicator;

    /**
     * BT-136.
     */
    protected Amount $actualAmount;

    /**
     * BT-140.
     */
    protected ?AllowanceReasonCode $reasonCode;

    /**
     * BT-139.
     */
    protected ?string $reason;

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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->chargeIndicator->toXML($document));
        $currentNode->appendChild($document->createElement('ram:ActualAmount', (string) $this->actualAmount->getValueRounded()));

        if ($this->reasonCode instanceof AllowanceReasonCode) {
            $currentNode->appendChild($document->createElement('ram:ReasonCode', $this->reasonCode->value));
        }

        if (\is_string($this->reason)) {
            $currentNode->appendChild($document->createElement('ram:Reason', $this->reason));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        $lineSpecifiedTradeAllowanceElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $lineSpecifiedTradeAllowanceElements->count()) {
            return [];
        }

        $lineSpecifiedTradeAllowances = [];

        foreach ($lineSpecifiedTradeAllowanceElements as $lineSpecifiedTradeAllowanceElement) {
            $actualAmountElements = $xpath->query('./ram:ActualAmount', $lineSpecifiedTradeAllowanceElement);
            $reasonCodeElements   = $xpath->query('./ram:ReasonCode', $lineSpecifiedTradeAllowanceElement);
            $reasonElements       = $xpath->query('./ram:Reason', $lineSpecifiedTradeAllowanceElement);

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
            AllowanceIndicator::fromXML($xpath, $lineSpecifiedTradeAllowanceElement);

            $lineSpecifiedTradeAllowance = new self((float) $actualAmount);

            if (1 === $reasonCodeElements->count()) {
                $reasonCode = AllowanceReasonCode::tryFrom($reasonCodeElements->item(0)->nodeValue);

                if (null === $reasonCode) {
                    throw new \Exception('Wrong ReasonCode');
                }

                $lineSpecifiedTradeAllowance->setReasonCode($reasonCode);
            }

            if (1 === $reasonElements->count()) {
                $lineSpecifiedTradeAllowance->setReason($reasonElements->item(0)->nodeValue);
            }

            $lineSpecifiedTradeAllowances[] = $lineSpecifiedTradeAllowance;
        }

        return $lineSpecifiedTradeAllowances;
    }
}
