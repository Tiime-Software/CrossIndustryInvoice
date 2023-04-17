<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

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
}
