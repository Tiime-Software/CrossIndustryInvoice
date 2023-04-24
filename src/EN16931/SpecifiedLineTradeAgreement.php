<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeAgreement\BuyerOrderReferencedDocument;

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

    public function setBuyerOrderReferencedDocument(?BuyerOrderReferencedDocument $buyerOrderReferencedDocument): static
    {
        $this->buyerOrderReferencedDocument = $buyerOrderReferencedDocument;

        return $this;
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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedLineTradeAgreement');

        if ($this->buyerOrderReferencedDocument instanceof BuyerOrderReferencedDocument) {
            $element->appendChild($this->buyerOrderReferencedDocument->toXML($document));
        }

        if ($this->grossPriceProductTradePrice instanceof GrossPriceProductTradePrice) {
            $element->appendChild($this->grossPriceProductTradePrice->toXML($document));
        }

        $element->appendChild($this->netPriceProductTradePrice->toXML($document));

        return $element;
    }
}
