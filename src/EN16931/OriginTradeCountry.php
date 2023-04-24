<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\CountryAlpha2Code;

/**
 * BT-159-00.
 */
class OriginTradeCountry
{
    /**
     * BT-159.
     */
    private ?CountryAlpha2Code $identifier;

    public function __construct()
    {
    }

    public function getIdentifier(): ?CountryAlpha2Code
    {
        return $this->identifier;
    }

    public function setIdentifier(?CountryAlpha2Code $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:OriginTradeCountry');

        $element->appendChild($document->createElement('ram:ID', $this->identifier->value));

        return $element;
    }
}
