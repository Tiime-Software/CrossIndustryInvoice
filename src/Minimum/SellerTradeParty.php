<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

/**
 * BG-4
 */
class SellerTradeParty
{
    /**
     * BT-27
     */
    private string $name;

    /**
     * BT-30-00
     */
    private ?SellerSpecifiedLegalOrganization $specifiedLegalOrganization;

    /**
     * BG-5
     */
    private PostalTradeAddress $postalTradeAddress;

    /**
     * BT-31-00
     *
     * @var array<int, SpecifiedTaxRegistration>
     */
    private array $specifiedTaxRegistrations;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        $this->name = $name;
        $this->postalTradeAddress = $postalTradeAddress;
        $this->specifiedLegalOrganization = null;
        $this->specifiedTaxRegistrations = [];
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

    public function getSpecifiedTaxRegistrations(): array
    {
        return $this->specifiedTaxRegistrations;
    }

    public function setSpecifiedTaxRegistrations(array $specifiedTaxRegistrations): void
    {
        $this->specifiedTaxRegistrations = $specifiedTaxRegistrations;
    }
}