<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\EN16931\DataType\Identifier\BuyerIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;

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
    private ?BuyerIdentifier $globalId;

    /**
     * BT-44.
     */
    private string $name;

    /**
     * BT-47-00.
     */
    private ?BuyerSpecifiedLegalOrganization $specifiedLegalOrganization;

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
    private ?VatIdentifier $specifiedTaxRegistration;
}
