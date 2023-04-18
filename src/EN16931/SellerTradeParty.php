<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\SellerTradeParty\SellerIdentifier;
use Tiime\CrossIndustryInvoice\DataType\SellerTradeParty\SellerIdentifierGlobalId;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\DefinedTradeContact;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\SpecifiedTaxRegistration;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\SpecifiedTaxRegistrationVAT;

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
     * @var array<int, SellerIdentifierGlobalId>
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
     *
     * @var array<int, SpecifiedTaxRegistrationVAT>
     */
    private array $specifiedTaxRegistrationVATs;

    /**
     * BT-32-00.
     *
     * @var array<int, SpecifiedTaxRegistration>
     */
    private array $specifiedTaxRegistrations;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        $this->name                         = $name;
        $this->postalTradeAddress           = $postalTradeAddress;
        $this->ids                          = [];
        $this->globalIds                    = [];
        $this->specifiedTaxRegistrationVATs = [];
        $this->specifiedTaxRegistrations    = [];
        $this->description                  = null;
        $this->specifiedLegalOrganization   = null;
        $this->definedTradeContact          = null;
        $this->uriUniversalCommunication    = null;
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

    public function getSpecifiedTaxRegistrationVATs(): array
    {
        return $this->specifiedTaxRegistrationVATs;
    }

    public function setSpecifiedTaxRegistrationVATs(array $specifiedTaxRegistrationVATs): void
    {
        $this->specifiedTaxRegistrationVATs = $specifiedTaxRegistrationVATs;
    }

    public function getSpecifiedTaxRegistrations(): array
    {
        return $this->specifiedTaxRegistrations;
    }

    public function setSpecifiedTaxRegistrations(array $specifiedTaxRegistrations): void
    {
        $this->specifiedTaxRegistrations = $specifiedTaxRegistrations;
    }
}
