<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty;

use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-46-0 & BT-46-1.
 */
class BuyerIdentifierGlobalId
{
    /**
     * BT-46-0.
     */
    private string $value;

    /**
     * BT-46-1.
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
