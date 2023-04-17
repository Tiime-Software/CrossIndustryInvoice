<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;

use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-29-0 & BT-29-1.
 */
class SellerIdentifierGlobalId
{
    /**
     * BT-29-0.
     */
    private string $globalID;

    /**
     * BT-29-1.
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
