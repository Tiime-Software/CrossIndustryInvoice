<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BG-11.
 */
class SellerTaxRepresentativeParty
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
    private VatIdentifier $specifiedTaxRegistration;
}
