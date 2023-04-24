<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BT-131-00.
 */
class SpecifiedTradeSettlementLineMonetarySummation
{
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
        $element = $document->createElement('ram:SpecifiedTradeSettlementLineMonetarySummation');

        $element->appendChild($document->createElement('ram:LineTotalAmount', (string) $this->lineTotalAmount->getValueRounded()));

        return $element;
    }
}
