<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty;

use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-60-0 & BT-60-1.
 */
class PayeeIdentifierGlobalId
{
    /**
     * BT-60-0.
     */
    private string $value;

    /**
     * BT-60-1.
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
