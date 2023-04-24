<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BuyerGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\EN16931\BuyerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistration;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty\BuyerIdentifier;
use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty\DefinedTradeContact;

/**
 * BG-7.
 */
class BuyerTradeParty
{
    /**
     * BT-46.
     */
    private ?BuyerIdentifier $identifier;

    /**
     * BT-46-0 & BT-46-1.
     */
    private ?BuyerGlobalIdentifier $globalIdentifier;

    /**
     * BT-44.
     */
    private string $name;

    /**
     * BT-47-00.
     */
    private ?BuyerSpecifiedLegalOrganization $specifiedLegalOrganization;

    /**
     * BG-9.
     */
    private ?DefinedTradeContact $definedTradeContact;

    /**
     * BG-8.
     */
    private PostalTradeAddress $postalTradeAddress;

    /**
     * BT-49-00.
     */
    private ?URIUniversalCommunication $URIUniversalCommunication;

    /**
     * BT-48-00.
     */
    private ?SpecifiedTaxRegistration $specifiedTaxRegistration;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        $this->name                       = $name;
        $this->postalTradeAddress         = $postalTradeAddress;
        $this->identifier                 = null;
        $this->globalIdentifier           = null;
        $this->specifiedLegalOrganization = null;
        $this->definedTradeContact        = null;
        $this->URIUniversalCommunication  = null;
        $this->specifiedTaxRegistration   = null;
    }

    public function getIdentifier(): ?BuyerIdentifier
    {
        return $this->identifier;
    }

    public function setIdentifier(?BuyerIdentifier $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getGlobalIdentifier(): ?BuyerGlobalIdentifier
    {
        return $this->globalIdentifier;
    }

    public function setGlobalIdentifier(?BuyerGlobalIdentifier $globalIdentifier): void
    {
        $this->globalIdentifier = $globalIdentifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpecifiedLegalOrganization(): ?BuyerSpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?BuyerSpecifiedLegalOrganization $specifiedLegalOrganization): void
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

    public function getURIUniversalCommunication(): ?URIUniversalCommunication
    {
        return $this->URIUniversalCommunication;
    }

    public function setURIUniversalCommunication(?URIUniversalCommunication $URIUniversalCommunication): void
    {
        $this->URIUniversalCommunication = $URIUniversalCommunication;
    }

    public function getSpecifiedTaxRegistration(): ?SpecifiedTaxRegistration
    {
        return $this->specifiedTaxRegistration;
    }

    public function setSpecifiedTaxRegistration(?SpecifiedTaxRegistration $specifiedTaxRegistration): void
    {
        $this->specifiedTaxRegistration = $specifiedTaxRegistration;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:BuyerTradeParty');

        if ($this->identifier instanceof BuyerIdentifier) {
            $element->appendChild($this->identifier->toXML($document));
        }

        if ($this->globalIdentifier instanceof BuyerGlobalIdentifier) {
            $element->appendChild($this->globalIdentifier->toXML($document));
        }

        $element->appendChild($document->createElement('ram:Name', $this->name));

        if ($this->specifiedLegalOrganization instanceof BuyerSpecifiedLegalOrganization) {
            $element->appendChild($this->specifiedLegalOrganization->toXML($document));
        }

        if ($this->definedTradeContact instanceof DefinedTradeContact) {
            $element->appendChild($this->definedTradeContact->toXML($document));
        }

        $element->appendChild($this->postalTradeAddress->toXML($document));

        if ($this->URIUniversalCommunication instanceof URIUniversalCommunication) {
            $element->appendChild($this->URIUniversalCommunication->toXML($document));
        }

        if ($this->specifiedTaxRegistration instanceof SpecifiedTaxRegistration) {
            $element->appendChild($this->specifiedTaxRegistration->toXML($document));
        }

        return $element;
    }
}
