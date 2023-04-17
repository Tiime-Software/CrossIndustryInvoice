<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\SellerTradeParty\SellerIdentifier;
use Tiime\CrossIndustryInvoice\DataType\SellerTradeParty\SellerIdentifierGlobalId;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
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
     */
    private VatIdentifier $specifiedTaxRegistration;
}
