<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\SellerGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\DefinedTradeContact;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\SpecifiedTaxRegistration;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\SpecifiedTaxRegistrationVAT;
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
    private array $ids;

    /**
     * BT-29-0 & BT-29-1.
     *
     * @var array<int, SellerGlobalIdentifier>
     */
    private array $globalIds;

    /**
     * BT-27.
     */
    private string $name;

    /**
     * BT-33.
     */
    private ?string $description;

    /**
     * BT-30-00.
     */
    private ?SellerSpecifiedLegalOrganization $specifiedLegalOrganization;

    /**
     * BG-6.
     */
    private ?DefinedTradeContact $definedTradeContact;

    /**
     * BG-5.
     */
    private PostalTradeAddress $postalTradeAddress;

    /**
     * BT-34-00.
     */
    private ?URIUniversalCommunication $uriUniversalCommunication;

    /**
     * BT-31-00.
     */
    private ?SpecifiedTaxRegistrationVAT $specifiedTaxRegistrationVAT;

    /**
     * BT-32-00.
     */
    private ?SpecifiedTaxRegistration $specifiedTaxRegistration;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        $this->name                         = $name;
        $this->postalTradeAddress           = $postalTradeAddress;
        $this->ids                          = [];
        $this->globalIds                    = [];
        $this->description                  = null;
        $this->specifiedLegalOrganization   = null;
        $this->definedTradeContact          = null;
        $this->uriUniversalCommunication    = null;
        $this->specifiedTaxRegistrationVAT  = null;
        $this->specifiedTaxRegistration     = null;
    }

    public function getIds(): array
    {
        return $this->ids;
    }

    public function setIds(array $ids): void
    {
        $this->ids = $ids;
    }

    public function getGlobalIds(): array
    {
        return $this->globalIds;
    }

    public function setGlobalIds(array $globalIds): void
    {
        $this->globalIds = $globalIds;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getSpecifiedLegalOrganization(): ?SellerSpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?SellerSpecifiedLegalOrganization $specifiedLegalOrganization): void
    {
        $this->specifiedLegalOrganization = $specifiedLegalOrganization;
    }

    public function getDefinedTradeContact(): ?DefinedTradeContact
    {
        return $this->definedTradeContact;
    }

    public function setDefinedTradeContact(?DefinedTradeContact $definedTradeContact): void
    {
        $this->definedTradeContact = $definedTradeContact;
    }

    public function getPostalTradeAddress(): PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function getUriUniversalCommunication(): ?URIUniversalCommunication
    {
        return $this->uriUniversalCommunication;
    }

    public function setUriUniversalCommunication(?URIUniversalCommunication $uriUniversalCommunication): void
    {
        $this->uriUniversalCommunication = $uriUniversalCommunication;
    }

    public function getSpecifiedTaxRegistrationVAT(): ?SpecifiedTaxRegistrationVAT
    {
        return $this->specifiedTaxRegistrationVAT;
    }

    public function setSpecifiedTaxRegistrationVATs(?SpecifiedTaxRegistrationVAT $specifiedTaxRegistrationVAT): void
    {
        $this->specifiedTaxRegistrationVAT = $specifiedTaxRegistrationVAT;
    }

    public function getSpecifiedTaxRegistrations(): ?SpecifiedTaxRegistration
    {
        return $this->specifiedTaxRegistration;
    }

    public function setSpecifiedTaxRegistrations(?SpecifiedTaxRegistration $specifiedTaxRegistration): void
    {
        $this->specifiedTaxRegistration = $specifiedTaxRegistration;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SellerTradeParty');

        foreach ($this->ids as $id) {
            $element->appendChild($document->createElement('ram:ID', $id->value));
        }

        foreach ($this->globalIds as $globalId) {
            $globalIdentifierElement = $document->createElement('ram:GlobalID', $globalId->value);
            $globalIdentifierElement->setAttribute('schemeID', $globalId->scheme->value);

            $element->appendChild($globalIdentifierElement);
        }

        $element->appendChild($document->createElement('ram:Name', $this->name));

        if (is_string($this->description)) {
            $element->appendChild($document->createElement('ram:Description', $this->description));
        }

        if ($this->specifiedLegalOrganization instanceof SellerSpecifiedLegalOrganization) {
            $element->appendChild($this->specifiedLegalOrganization->toXML($document));
        }

        if ($this->definedTradeContact instanceof DefinedTradeContact) {
            $element->appendChild($this->definedTradeContact->toXML($document));
        }

        $element->appendChild($this->postalTradeAddress->toXML($document));

        if ($this->uriUniversalCommunication instanceof URIUniversalCommunication) {
            $element->appendChild($this->uriUniversalCommunication->toXML($document));
        }

        if ($this->specifiedTaxRegistrationVAT instanceof SpecifiedTaxRegistrationVAT) {
            $element->appendChild($this->specifiedTaxRegistrationVAT->toXML($document));
        }

        if ($this->specifiedTaxRegistration instanceof SpecifiedTaxRegistration) {
            $element->appendChild($this->specifiedTaxRegistration->toXML($document));
        }

        return $element;
    }
}
