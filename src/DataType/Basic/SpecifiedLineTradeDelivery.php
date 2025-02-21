<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BT-129-00.
 */
class SpecifiedLineTradeDelivery
{
    protected const string XML_NODE = 'ram:SpecifiedLineTradeDelivery';

    /**
     * @param BilledQuantity $billedQuantity - BT-129 & BT-130
     */
    public function __construct(
        private readonly BilledQuantity $billedQuantity,
    ) {
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

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
    {
        $specifiedLineTradeDeliveryElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $specifiedLineTradeDeliveryElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedLineTradeDeliveryElement */
        $specifiedLineTradeDeliveryElement = $specifiedLineTradeDeliveryElements->item(0);

        $billedQuantity = BilledQuantity::fromXML($xpath, $specifiedLineTradeDeliveryElement);

        return new self($billedQuantity);
    }
}
