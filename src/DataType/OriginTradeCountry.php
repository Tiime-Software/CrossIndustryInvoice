<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\Codelist\CountryAlpha2Code;

/**
 * BT-159-00.
 */
class OriginTradeCountry
{
    protected const string XML_NODE = 'ram:OriginTradeCountry';

    /**
     * @param CountryAlpha2Code $identifier - BT-159
     */
    public function __construct(
        private readonly CountryAlpha2Code $identifier,
    ) {
    }

    public function getIdentifier(): ?CountryAlpha2Code
    {
        return $this->identifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:ID', $this->identifier->value));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $originTradeCountryElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $originTradeCountryElements->count()) {
            return null;
        }

        if ($originTradeCountryElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $originTradeCountryElement */
        $originTradeCountryElement = $originTradeCountryElements->item(0);

        $identifierElements = $xpath->query('./ram:ID', $originTradeCountryElement);

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $identifier = CountryAlpha2Code::tryFrom($identifierElements->item(0)->nodeValue);

        if (!$identifier instanceof CountryAlpha2Code) {
            throw new \Exception('Wrong ID');
        }

        return new self($identifier);
    }
}
