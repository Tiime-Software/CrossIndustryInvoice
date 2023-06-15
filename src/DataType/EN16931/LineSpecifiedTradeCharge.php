<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\ChargeIndicator;
use Tiime\EN16931\BusinessTermsGroup\InvoiceLineCharge;
use Tiime\EN16931\DataType\ChargeReasonCode;
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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->getChargeIndicator()->toXML($document));

        if ($this->calculationPercent instanceof Percentage) {
            $currentNode->appendChild($document->createElement('ram:CalculationPercent', (string) $this->calculationPercent->getValueRounded()));
        }

        if ($this->basisAmount instanceof Amount) {
            $currentNode->appendChild($document->createElement('ram:BasisAmount', (string) $this->basisAmount->getValueRounded()));
        }

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
        $lineSpecifiedTradeChargeElements = $xpath->query(sprintf('.//%s[ram:ChargeIndicator/udt:Indicator[text() = \'true\']]', self::XML_NODE), $currentElement);

        if (0 === $lineSpecifiedTradeChargeElements->count()) {
            return [];
        }

        $lineSpecifiedTradeCharges = [];

        foreach ($lineSpecifiedTradeChargeElements as $lineSpecifiedTradeChargeElement) {
            $calculationPercentElements = $xpath->query('.//ram:CalculationPercent', $lineSpecifiedTradeChargeElement);
            $basisAmountElements        = $xpath->query('.//ram:BasisAmount', $lineSpecifiedTradeChargeElement);
            $actualAmountElements       = $xpath->query('.//ram:ActualAmount', $lineSpecifiedTradeChargeElement);
            $reasonCodeElements         = $xpath->query('.//ram:ReasonCode', $lineSpecifiedTradeChargeElement);
            $reasonElements             = $xpath->query('.//ram:Reason', $lineSpecifiedTradeChargeElement);

            if ($calculationPercentElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            if ($basisAmountElements->count() > 1) {
                throw new \Exception('Malformed');
            }

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

            if (1 === $calculationPercentElements->count()) {
                $lineSpecifiedTradeCharge->setCalculationPercent((float) $calculationPercentElements->item(0)->nodeValue);
            }

            if (1 === $basisAmountElements->count()) {
                $lineSpecifiedTradeCharge->setBasisAmount((float) $basisAmountElements->item(0)->nodeValue);
            }

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

    public static function fromEN16931(InvoiceLineCharge $charge): self
    {
        return (new self($charge->getAmount()))
            ->setCalculationPercent($charge->getPercentage())
            ->setBasisAmount($charge->getBaseAmount())
            ->setReasonCode($charge->getReasonCode())
            ->setReason($charge->getReason());
    }
}
