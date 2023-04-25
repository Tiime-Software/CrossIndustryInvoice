<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\Basic\GrossPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\EN16931\NetPriceProductTradePrice;

class SpecifiedLineTradeAgreement
{

    /**
     * BT-148-00.
     */
    private ?GrossPriceProductTradePrice $grossPriceProductTradePrice;


    /**
     * BT-146-00.
     */
    private NetPriceProductTradePrice $netPriceProductTradePrice;

    public function __construct(NetPriceProductTradePrice $netPriceProductTradePrice)
    {
        $this->grossPriceProductTradePrice = null;
        $this->netPriceProductTradePrice = $netPriceProductTradePrice;
    }

    public function getGrossPriceProductTradePrice(): ?GrossPriceProductTradePrice
    {
        return $this->grossPriceProductTradePrice;
    }

    public function setGrossPriceProductTradePrice(?GrossPriceProductTradePrice $grossPriceProductTradePrice): static
    {
        $this->grossPriceProductTradePrice = $grossPriceProductTradePrice;

        return $this;
    }

    public function getNetPriceProductTradePrice(): NetPriceProductTradePrice
    {
        return $this->netPriceProductTradePrice;
    }
}
