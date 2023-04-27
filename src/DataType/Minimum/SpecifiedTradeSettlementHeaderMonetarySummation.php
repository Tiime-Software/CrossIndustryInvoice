<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-22.
 */
class SpecifiedTradeSettlementHeaderMonetarySummation
{
    /**
     * BT-109.
     */
    private Amount $taxBasisTotalAmount;

    /**
     * BT-110 & BT-110-0.
     */
    private ?TaxTotalAmount $taxTotalAmount;

    /**
     * BT-112.
     */
    private Amount $grandTotalAmount;

    /**
     * BT-115.
     */
    private Amount $duePayableAmount;

    public function __construct(
        float $taxBasisTotalAmount,
        float $grandTotalAmount,
        float $duePayableAmount,
        TaxTotalAmount $taxTotalAmount = null
    ) {
        $this->taxBasisTotalAmount = new Amount($taxBasisTotalAmount);
        $this->grandTotalAmount    = new Amount($grandTotalAmount);
        $this->duePayableAmount    = new Amount($duePayableAmount);
        $this->taxTotalAmount      = $taxTotalAmount;
    }

    public function getTaxBasisTotalAmount(): float
    {
        return $this->taxBasisTotalAmount->getValueRounded();
    }

    public function getTaxTotalAmount(): ?TaxTotalAmount
    {
        return $this->taxTotalAmount;
    }

    public function getGrandTotalAmount(): float
    {
        return $this->grandTotalAmount->getValueRounded();
    }

    public function getDuePayableAmount(): float
    {
        return $this->duePayableAmount->getValueRounded();
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTradeSettlementHeaderMonetarySummation');

        $element->appendChild($document->createElement('ram:TaxBasisTotalAmount', (string) $this->taxBasisTotalAmount->getValueRounded()));

        if ($this->taxTotalAmount instanceof TaxTotalAmount) {
            $element->appendChild($this->taxTotalAmount->toXML($document));
        }

        $element->appendChild($document->createElement('ram:GrandTotalAmount', (string) $this->grandTotalAmount->getValueRounded()));
        $element->appendChild($document->createElement('ram:DuePayableAmount', (string) $this->duePayableAmount->getValueRounded()));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $specifiedTradeSettlementHeaderMonetarySummationElements = $xpath->query('//ram:SpecifiedTradeSettlementHeaderMonetarySummation', $currentElement);

        if (1 !== $specifiedTradeSettlementHeaderMonetarySummationElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedTradeSettlementHeaderMonetarySummationElement */
        $specifiedTradeSettlementHeaderMonetarySummationElement = $specifiedTradeSettlementHeaderMonetarySummationElements->item(0);

        $taxBasisTotalAmountElements = $xpath->query('//ram:TaxBasisTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);
        $grandTotalAmountElements    = $xpath->query('//ram:GrandTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);
        $duePayableAmountElements    = $xpath->query('//ram:DuePayableAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);

        if (1 !== $taxBasisTotalAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $grandTotalAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $duePayableAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        $taxBasisTotalAmount = $taxBasisTotalAmountElements->item(0)->nodeValue;
        $grandTotalAmount    = $grandTotalAmountElements->item(0)->nodeValue;
        $duePayableAmount    = $duePayableAmountElements->item(0)->nodeValue;
        $taxTotalAmount      = TaxTotalAmount::fromXML($xpath, $specifiedTradeSettlementHeaderMonetarySummationElement);

        return new static((float) $taxBasisTotalAmount, (float) $grandTotalAmount, (float) $duePayableAmount, $taxTotalAmount);
    }
}
