<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\SellerGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistration;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\EN16931\DataType\Identifier\SellerIdentifier;

/**
 * BG-4.
 */
class SellerTradeParty
{
    protected const XML_NODE = 'ram:SellerTradeParty';

    /**
     * BT-29.
     *
     * @var array<int, SellerIdentifier>
     */
    private array $identifiers;

    /**
     * BT-29-0 & BT-29-1.
     *
     * @var array<int, SellerGlobalIdentifier>
     */
    private array $globalIdentifiers;

    /**
     * BT-27.
     */
    private string $name;

    /**
     * BT-30-00.
     */
    private ?SellerSpecifiedLegalOrganization $specifiedLegalOrganization;

    /**
     * BG-5.
     */
    private PostalTradeAddress $postalTradeAddress;

    /**
     * BT-34-00.
     */
    private ?URIUniversalCommunication $URIUniversalCommunication;

    /**
     * BT-31-00.
     *
     * @var array<int, SpecifiedTaxRegistration>
     */
    private array $specifiedTaxRegistrations;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        $this->name                       = $name;
        $this->postalTradeAddress         = $postalTradeAddress;
        $this->identifiers                = [];
        $this->globalIdentifiers          = [];
        $this->specifiedTaxRegistrations  = [];
        $this->specifiedLegalOrganization = null;
        $this->URIUniversalCommunication  = null;
    }

    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

    public function setIdentifiers(array $identifiers): static
    {
        $tmpIdentifiers = [];

        foreach ($identifiers as $identifier) {
            if (!$identifier instanceof SellerIdentifier) {
                throw new \TypeError();
            }

            $tmpIdentifiers[] = $identifier;
        }

        $this->identifiers = $tmpIdentifiers;

        return $this;
    }

    public function getGlobalIdentifiers(): array
    {
        return $this->globalIdentifiers;
    }

    public function setGlobalIdentifiers(array $globalIdentifiers): static
    {
        $tmpGlobalIdentifiers = [];

        foreach ($globalIdentifiers as $globalIdentifier) {
            if (!$globalIdentifier instanceof SellerGlobalIdentifier) {
                throw new \TypeError();
            }

            $tmpGlobalIdentifiers[] = $globalIdentifier;
        }

        $this->globalIdentifiers = $tmpGlobalIdentifiers;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpecifiedLegalOrganization(): ?SellerSpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?SellerSpecifiedLegalOrganization $specifiedLegalOrganization): static
    {
        $this->specifiedLegalOrganization = $specifiedLegalOrganization;

        return $this;
    }

    public function getPostalTradeAddress(): PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function setURIUniversalCommunication(?URIUniversalCommunication $URIUniversalCommunication): static
    {
        $this->URIUniversalCommunication = $URIUniversalCommunication;

        return $this;
    }

    public function getSpecifiedTaxRegistrations(): array
    {
        return $this->specifiedTaxRegistrations;
    }

    public function setSpecifiedTaxRegistrations(array $specifiedTaxRegistrations): static
    {
        $tmpSpecifiedTaxRegistrations = [];

        foreach ($specifiedTaxRegistrations as $specifiedTaxRegistration) {
            if (!$specifiedTaxRegistration instanceof SpecifiedTaxRegistration) {
                throw new \TypeError();
            }

            $tmpSpecifiedTaxRegistrations[] = $specifiedTaxRegistration;
        }

        $this->specifiedTaxRegistrations = $tmpSpecifiedTaxRegistrations;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        foreach ($this->identifiers as $identifier) {
            $currentNode->appendChild($document->createElement('ram:ID', $identifier->value));
        }

        foreach ($this->globalIdentifiers as $globalIdentifier) { // move inside class
            $globalIdentifierElement = $document->createElement('ram:GlobalID', $globalIdentifier->value);
            $globalIdentifierElement->setAttribute('schemeID', $globalIdentifier->scheme->value);
            $currentNode->appendChild($globalIdentifierElement);
        }

        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        if (null !== $this->specifiedLegalOrganization) {
            $currentNode->appendChild($this->specifiedLegalOrganization->toXML($document));
        }

        $currentNode->appendChild($this->postalTradeAddress->toXML($document));

        if (null !== $this->URIUniversalCommunication) {
            $currentNode->appendChild($this->URIUniversalCommunication->toXML($document));
        }

        foreach ($this->specifiedTaxRegistrations as $specifiedTaxRegistration) {
            $currentNode->appendChild($specifiedTaxRegistration->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $sellerTradePartyElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $sellerTradePartyElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerTradePartyElement */
        $sellerTradePartyElement = $sellerTradePartyElements->item(0);

        $identifierElements = $xpath->query('.//ram:ID', $sellerTradePartyElement);

        $identifiers = [];

        foreach ($identifierElements as $identifierElement) {
            $identifier = $identifierElement->nodeValue;

            $identifiers[] = new SellerIdentifier($identifier);
        }

        $nameElements = $xpath->query('.//ram:Name', $sellerTradePartyElement);

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $globalIdentifiers          = SellerGlobalIdentifier::fromXML($xpath, $sellerTradePartyElement);
        $specifiedLegalOrganization = SellerSpecifiedLegalOrganization::fromXML($xpath, $sellerTradePartyElement);
        $postalTradeAddress         = PostalTradeAddress::fromXML($xpath, $sellerTradePartyElement);
        $URIUniversalCommunication  = URIUniversalCommunication::fromXML($xpath, $sellerTradePartyElement);
        $specifiedTaxRegistrations  = SpecifiedTaxRegistration::fromXML($xpath, $sellerTradePartyElement);

        if (null === $postalTradeAddress) {
            throw new \Exception('Malformed');
        }

        $sellerTradeParty = new self($name, $postalTradeAddress);

        if (\count($identifiers) > 0) {
            $sellerTradeParty->setIdentifiers($identifiers);
        }

        if (\count($globalIdentifiers) > 0) {
            $sellerTradeParty->setGlobalIdentifiers($globalIdentifiers);
        }

        if (null !== $specifiedLegalOrganization) {
            $sellerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        if (null !== $URIUniversalCommunication) {
            $sellerTradeParty->setURIUniversalCommunication($URIUniversalCommunication);
        }

        if (\count($specifiedTaxRegistrations) > 0) {
            $sellerTradeParty->setSpecifiedTaxRegistrations($specifiedTaxRegistrations);
        }

        return $sellerTradeParty;
    }
}
