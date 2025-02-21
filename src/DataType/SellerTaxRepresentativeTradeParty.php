<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BG-11.
 */
class SellerTaxRepresentativeTradeParty
{
    protected const string XML_NODE = 'ram:SellerTaxRepresentativeTradeParty';

    /**
     * @param string                     $name                       - BT-62
     * @param PostalTradeAddress         $postalTradeAddress         - BG-12
     * @param SpecifiedTaxRegistrationVA $specifiedTaxRegistrationVA - BT-63-00
     */
    public function __construct(
        private readonly string $name,
        private readonly PostalTradeAddress $postalTradeAddress,
        private readonly SpecifiedTaxRegistrationVA $specifiedTaxRegistrationVA,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPostalTradeAddress(): PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function getSpecifiedTaxRegistrationVA(): SpecifiedTaxRegistrationVA
    {
        return $this->specifiedTaxRegistrationVA;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:Name', $this->name));
        $currentNode->appendChild($this->postalTradeAddress->toXML($document));
        $currentNode->appendChild($this->specifiedTaxRegistrationVA->toXML($document));

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): ?self
    {
        $sellerTaxRepresentativeTradePartyElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $sellerTaxRepresentativeTradePartyElements->count()) {
            return null;
        }

        if ($sellerTaxRepresentativeTradePartyElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerTaxRepresentativeTradePartyElement */
        $sellerTaxRepresentativeTradePartyElement = $sellerTaxRepresentativeTradePartyElements->item(0);

        $nameElements = $xpath->query('./ram:Name', $sellerTaxRepresentativeTradePartyElement);

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $postalTradeAddress         = PostalTradeAddress::fromXML($xpath, $sellerTaxRepresentativeTradePartyElement);
        $specifiedTaxRegistrationVA = SpecifiedTaxRegistrationVA::fromXML($xpath, $sellerTaxRepresentativeTradePartyElement);

        if (null === $postalTradeAddress) {
            throw new \Exception('Malformed');
        }

        if (!$specifiedTaxRegistrationVA instanceof SpecifiedTaxRegistrationVA) {
            throw new \Exception('Malformed');
        }

        return new self($name, $postalTradeAddress, $specifiedTaxRegistrationVA);
    }
}
