<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BT-131-00.
 */
class SpecifiedTradeSettlementLineMonetarySummation
{
    protected const string XML_NODE = 'ram:SpecifiedTradeSettlementLineMonetarySummation';

    /**
     * BT-131.
     */
    private Amount $lineTotalAmount;

    public function __construct(float $lineTotalAmount)
    {
        $this->lineTotalAmount = new Amount($lineTotalAmount);
    }

    public function getLineTotalAmount(): Amount
    {
        return $this->lineTotalAmount;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:LineTotalAmount', $this->lineTotalAmount->getFormattedValueRounded()));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $specifiedTradeSettlementLineMonetarySummationElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $specifiedTradeSettlementLineMonetarySummationElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedTradeSettlementLineMonetarySummationElement */
        $specifiedTradeSettlementLineMonetarySummationElement = $specifiedTradeSettlementLineMonetarySummationElements->item(0);

        $lineTotalAmountElements = $xpath->query('./ram:LineTotalAmount', $specifiedTradeSettlementLineMonetarySummationElement);

        if (1 !== $lineTotalAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        $lineTotalAmount = $lineTotalAmountElements->item(0)->nodeValue;

        return new self((float) $lineTotalAmount);
    }
}
