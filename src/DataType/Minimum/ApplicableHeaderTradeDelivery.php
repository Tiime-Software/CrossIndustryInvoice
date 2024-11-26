<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BG-13-00.
 */
class ApplicableHeaderTradeDelivery
{
    protected const string XML_NODE = 'ram:ApplicableHeaderTradeDelivery';

    public function toXML(\DOMDocument $document): \DOMElement
    {
        return $document->createElement(self::XML_NODE);
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
    {
        $applicableHeaderTradeDeliveryElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeDeliveryElements->count()) {
            throw new \Exception('Malformed');
        }

        return new self();
    }
}
