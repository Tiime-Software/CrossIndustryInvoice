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

    public function setIdentifiers(array $identifiers): void
    {
        $this->identifiers = $identifiers;
    }

    public function getGlobalIdentifiers(): array
    {
        return $this->globalIdentifiers;
    }

    public function setGlobalIdentifiers(array $globalIdentifiers): void
    {
        $this->globalIdentifiers = $globalIdentifiers;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpecifiedLegalOrganization(): ?SellerSpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?SellerSpecifiedLegalOrganization $specifiedLegalOrganization): void
    {
        $this->specifiedLegalOrganization = $specifiedLegalOrganization;
    }

    public function getPostalTradeAddress(): PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function setURIUniversalCommunication(?URIUniversalCommunication $URIUniversalCommunication): void
    {
        $this->URIUniversalCommunication = $URIUniversalCommunication;
    }

    public function getSpecifiedTaxRegistrations(): array
    {
        return $this->specifiedTaxRegistrations;
    }

    public function setSpecifiedTaxRegistrations(array $specifiedTaxRegistrations): void
    {
        $this->specifiedTaxRegistrations = $specifiedTaxRegistrations;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:SellerTradeParty');

        foreach ($this->identifiers as $identifier) {
            $currentNode->appendChild($document->createElement('ram:ID', $identifier->value));
        }

        foreach ($this->globalIdentifiers as $globalIdentifier) {
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
}
