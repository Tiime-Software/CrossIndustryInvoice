<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty\BuyerIdentifier;
use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty\BuyerIdentifierGlobalId;
use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty\DefinedTradeContact;
use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty\SpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty\SpecifiedTaxRegistration;

/**
 * BG-7.
 */
class BuyerTradeParty
{
    /**
     * BT-46.
     */
    private ?BuyerIdentifier $id;

    /**
     * BT-46-0 & BT-46-1.
     */
    private ?BuyerIdentifierGlobalId $globalId;

    /**
     * BT-44.
     */
    private string $name;

    /**
     * BT-47-00.
     */
    private ?SpecifiedLegalOrganization $specifiedLegalOrganization;

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
        $this->id                         = null;
        $this->globalId                   = null;
        $this->specifiedLegalOrganization = null;
        $this->definedTradeContact        = null;
        $this->URIUniversalCommunication  = null;
        $this->specifiedTaxRegistration   = null;
    }

    public function getId(): ?BuyerIdentifier
    {
        return $this->id;
    }

    public function setId(?BuyerIdentifier $id): void
    {
        $this->id = $id;
    }

    public function getGlobalId(): ?BuyerIdentifierGlobalId
    {
        return $this->globalId;
    }

    public function setGlobalId(?BuyerIdentifierGlobalId $globalId): void
    {
        $this->globalId = $globalId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpecifiedLegalOrganization(): ?SpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?SpecifiedLegalOrganization $specifiedLegalOrganization): void
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
}
