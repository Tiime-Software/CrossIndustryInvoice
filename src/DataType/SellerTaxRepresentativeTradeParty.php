<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\SellerTaxRepresentativeTradeParty\SpecifiedTaxRegistration;

/**
 * BG-11.
 */
class SellerTaxRepresentativeTradeParty
{
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
}