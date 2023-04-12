<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BG-29.
 */
class SpecifiedLineTradeAgreement
{
    /**
     * BT-13-00.
     */
    private ?BuyerOrderReferencedDocument $buyerOrderReferencedDocument;

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
        $this->netPriceProductTradePrice = $netPriceProductTradePrice;
    }

    public function getBuyerOrderReferencedDocument(): ?BuyerOrderReferencedDocument
    {
        return $this->buyerOrderReferencedDocument;
    }

    public function setBuyerOrderReferencedDocument(?BuyerOrderReferencedDocument $buyerOrderReferencedDocument): void
    {
        $this->buyerOrderReferencedDocument = $buyerOrderReferencedDocument;
    }

    public function getGrossPriceProductTradePrice(): ?GrossPriceProductTradePrice
    {
        return $this->grossPriceProductTradePrice;
    }

    public function setGrossPriceProductTradePrice(?GrossPriceProductTradePrice $grossPriceProductTradePrice): void
    {
        $this->grossPriceProductTradePrice = $grossPriceProductTradePrice;
    }

    public function getNetPriceProductTradePrice(): NetPriceProductTradePrice
    {
        return $this->netPriceProductTradePrice;
    }
}
