<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;

use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BT-111 & BT-111-0.
 */
class TaxTotalAmountCurrency
{
    /**
     * BT-111.
     */
    private Amount $value;

    /**
     * BT-111-0.
     */
    private CurrencyCode $currencyID;

    public function __construct(Amount $value, CurrencyCode $currencyID)
    {
        $this->value      = $value;
        $this->currencyID = $currencyID;
    }

    public function getValue(): Amount
    {
        return $this->value;
    }

    public function getCurrencyID(): CurrencyCode
    {
        return $this->currencyID;
    }
}
