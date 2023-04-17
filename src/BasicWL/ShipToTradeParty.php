<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\Identifier\LocationIdentifier;

/**
 * BG-13.
 */
class ShipToTradeParty
{
    /**
     * BT-71.
     */
    private ?LocationIdentifier $id;

    /**
     * BT-71-0 & BT-71-1.
     */
    private ?LocationIdentifier $globalId;

    /**
     * BT-70.
     */
    private ?string $name;

    /**
     * BG-15.
     */
    private ?PostalTradeAddress $postalTradeAddress;
}
