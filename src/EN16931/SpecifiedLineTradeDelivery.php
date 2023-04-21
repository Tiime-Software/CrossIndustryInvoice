<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BT-129-00.
 */
class SpecifiedLineTradeDelivery
{
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
        $element = $document->createElement('ram:SpecifiedLineTradeDelivery');

        $element->appendChild($this->billedQuantity->toXML($document));

        return $element;
    }
}
