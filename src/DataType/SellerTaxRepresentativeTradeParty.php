<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;

/**
 * BG-11.
 */
class SellerTaxRepresentativeTradeParty
{
    protected const XML_NODE = 'ram:SellerTaxRepresentativeTradeParty';

    /**
     * BT-62.
     */
    private string $name;

    /**
     * BG-12.
     */
    private PostalTradeAddress $postalTradeAddress;

    /**
     * BT-63-00.
     */
    private SpecifiedTaxRegistration $specifiedTaxRegistration;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress, SpecifiedTaxRegistration $specifiedTaxRegistration)
    {
        $this->name                     = $name;
        $this->postalTradeAddress       = $postalTradeAddress;
        $this->specifiedTaxRegistration = $specifiedTaxRegistration;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPostalTradeAddress(): PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function getSpecifiedTaxRegistration(): SpecifiedTaxRegistration
    {
        return $this->specifiedTaxRegistration;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        $currentNode->appendChild($this->postalTradeAddress->toXML($document));

        $currentNode->appendChild($this->specifiedTaxRegistration->toXML($document));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $sellerTaxRepresentativeTradePartyElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $sellerTaxRepresentativeTradePartyElements->count()) {
            return null;
        }

        if ($sellerTaxRepresentativeTradePartyElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerTaxRepresentativeTradePartyElement */
        $sellerTaxRepresentativeTradePartyElement = $sellerTaxRepresentativeTradePartyElements->item(0);

        $nameElements = $xpath->query('.//ram:Name', $sellerTaxRepresentativeTradePartyElement);

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $postalTradeAddress        = PostalTradeAddress::fromXML($xpath, $sellerTaxRepresentativeTradePartyElement);
        $specifiedTaxRegistrations = SpecifiedTaxRegistration::fromXML($xpath, $sellerTaxRepresentativeTradePartyElement);

        if (null === $postalTradeAddress) {
            throw new \Exception('Malformed');
        }

        if (1 !== \count($specifiedTaxRegistrations)) {
            throw new \Exception('Malformed');
        }

        return new static($name, $postalTradeAddress, $specifiedTaxRegistrations[0]);
    }
}
