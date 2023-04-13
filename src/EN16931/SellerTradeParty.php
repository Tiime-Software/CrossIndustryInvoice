<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\SellerIdentifier;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\SellerIdentifierGlobalId;

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
    private ?SpecifiedLegalOrganization $specifiedLegalOrganization;

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
}
