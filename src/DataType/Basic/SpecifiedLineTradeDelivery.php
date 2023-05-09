<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

/**
 * BT-129-00.
 */
class SpecifiedLineTradeDelivery
{
    protected const XML_NODE = 'ram:SpecifiedLineTradeDelivery';

    /**
     * BT-129 & BT-130.
     */
    private BilledQuantity $billedQuantity;

    public function __construct(BilledQuantity $billedQuantity)
    {
        $this->billedQuantity = $billedQuantity;
    }

    public function getBilledQuantity(): BilledQuantity
    {
        return $this->billedQuantity;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($this->billedQuantity->toXML($document));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        // todo
    }
}
