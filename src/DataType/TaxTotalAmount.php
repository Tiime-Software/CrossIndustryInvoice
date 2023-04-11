<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\SemanticDataType\Amount;

class TaxTotalAmount
{
    /**
     * BT-110.
     */
    private Amount $value;

    /**
     * BT-110-0.
     */
    private CurrencyCode $currencyID;

    public function __construct(float $value, CurrencyCode $currencyID)
    {
        $this->value      = new Amount($value);
        $this->currencyID = $currencyID;
    }

    public function getValue(): float
    {
        return $this->value->getValueRounded();
    }

    public function getCurrencyID(): CurrencyCode
    {
        return $this->currencyID;
    }
}
