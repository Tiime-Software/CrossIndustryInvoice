<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty;

/**
 * BT-46.
 */
class BuyerIdentifier
{
    protected const XML_NODE = 'ram:ID';

    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        return $document->createElement(self::XML_NODE, $this->value);
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $buyerIdentifierElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $buyerIdentifierElements->count()) {
            return null;
        }

        if ($buyerIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $value = $buyerIdentifierElements->item(0)->nodeValue;

        return new self($value);
    }
}
