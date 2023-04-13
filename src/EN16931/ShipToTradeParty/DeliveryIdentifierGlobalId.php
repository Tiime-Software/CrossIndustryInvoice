<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ShipToTradeParty;

use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-71-0 & BT-71-1.
 */
class DeliveryIdentifierGlobalId
{
    /**
     * BT-71-0.
     */
    private string $value;

    /**
     * BT-71-1.
     */
    private InternationalCodeDesignator $schemeID;

    public function __construct(string $value, InternationalCodeDesignator $schemeID)
    {
        $this->value    = $value;
        $this->schemeID = $schemeID;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getSchemeID(): InternationalCodeDesignator
    {
        return $this->schemeID;
    }
}
