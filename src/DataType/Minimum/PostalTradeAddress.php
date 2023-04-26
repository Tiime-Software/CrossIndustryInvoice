<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\EN16931\DataType\CountryAlpha2Code;

/**
 * BG-5.
 */
class PostalTradeAddress
{
    /**
     * BT-40.
     */
    private CountryAlpha2Code $countryIdentifier;

    public function __construct(CountryAlpha2Code $countryIdentifier)
    {
        $this->countryIdentifier = $countryIdentifier;
    }

    public function getCountryIdentifier(): CountryAlpha2Code
    {
        return $this->countryIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:PostalTradeAddress');
        $currentNode->appendChild($document->createElement('ram:CountryID', $this->countryIdentifier->value));

        return $currentNode;
    }

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $countryIdentifierElements = $xpath->query('//ram:CountryID');

        if (1 !== $countryIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $countryIdentifier = CountryAlpha2Code::tryFrom($countryIdentifierElements->item(0)->nodeValue);

        if (null === $countryIdentifier) {
            throw new \Exception('Wrong country');
        }

        return new static($countryIdentifier);
    }
}
