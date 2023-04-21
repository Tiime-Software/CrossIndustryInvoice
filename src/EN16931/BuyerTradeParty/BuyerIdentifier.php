<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty;

/**
 * BT-46.
 */
class BuyerIdentifier
{
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
        return $document->createElement('ram:ID', $this->value);
    }
}
