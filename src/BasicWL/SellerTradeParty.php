<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\Identifier\ElectronicAddressIdentifier;
use Tiime\EN16931\DataType\Identifier\SellerIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;

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
    private array $id;

    /**
     * BT-29-0 & BT-29-1.
     *
     * @var array<int, SellerIdentifier>
     */
    private array $globalId;

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
    private ?ElectronicAddressIdentifier $URIUniversalCommunication;

    /**
     * BT-31-00.
     */
    private VatIdentifier $specifiedTaxRegistration;
}
