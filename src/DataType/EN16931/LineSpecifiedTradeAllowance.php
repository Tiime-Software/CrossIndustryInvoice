<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\AllowanceIndicator;
use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-27.
 */
class LineSpecifiedTradeAllowance extends \Tiime\CrossIndustryInvoice\DataType\Basic\LineSpecifiedTradeAllowance
{
    /**
     * BT-138.
     */
    private ?Percentage $calculationPercent;

    /**
     * BT-137.
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
        return $this->calculationPercent?->getValueRounded();
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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        // TODO

        $lineSpecifiedTradeAllowanceElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $lineSpecifiedTradeAllowanceElements->count()) {
            return [];
        }

        $lineSpecifiedTradeAllowances = [];

        foreach ($lineSpecifiedTradeAllowanceElements as $lineSpecifiedTradeAllowanceElement) {
            $calculationPercentElements = $xpath->query('.//ram:CalculationPercent', $lineSpecifiedTradeAllowanceElement);
            $basisAmountElements        = $xpath->query('.//ram:BasisAmount', $lineSpecifiedTradeAllowanceElement);
            $actualAmountElements       = $xpath->query('.//ram:ActualAmount', $lineSpecifiedTradeAllowanceElement);
            $reasonCodeElements         = $xpath->query('.//ram:ReasonCode', $lineSpecifiedTradeAllowanceElement);
            $reasonElements             = $xpath->query('.//ram:Reason', $lineSpecifiedTradeAllowanceElement);

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
            AllowanceIndicator::fromXML($xpath, $lineSpecifiedTradeAllowanceElement);

            $lineSpecifiedTradeAllowance = new static((float) $actualAmount);

            if (1 === $calculationPercentElements->count()) {
                $lineSpecifiedTradeAllowance->setCalculationPercent((float) $calculationPercentElements->item(0)->nodeValue);
            }

            if (1 === $basisAmountElements->count()) {
                $lineSpecifiedTradeAllowance->setBasisAmount((float) $basisAmountElements->item(0)->nodeValue);
            }

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
