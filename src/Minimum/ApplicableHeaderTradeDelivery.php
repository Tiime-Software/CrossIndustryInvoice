<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

/**
 * BG-13-00.
 */
class ApplicableHeaderTradeDelivery
{
    public function toXML(\DOMDocument $document): \DOMElement
    {
        return $document->createElement('ram:ApplicableHeaderTradeDelivery');
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $applicableHeaderTradeDeliveryElements = $xpath->query('.//ram:ApplicableHeaderTradeDelivery', $currentElement);

        if (1 !== $applicableHeaderTradeDeliveryElements->count()) {
            throw new \Exception('Malformed');
        }

        return new static();
    }
}
