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
    private string $globalID;

    /**
     * BT-46-1.
     */
    private InternationalCodeDesignator $schemeID;

    public function __construct(string $globalID, InternationalCodeDesignator $schemeID)
    {
        $this->globalID = $globalID;
        $this->schemeID = $schemeID;
    }

    public function getGlobalID(): string
    {
        return $this->globalID;
    }

    public function getSchemeID(): InternationalCodeDesignator
    {
        return $this->schemeID;
    }
}
