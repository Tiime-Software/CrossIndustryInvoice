<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\Basic\GrossPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\EN16931\NetPriceProductTradePrice;

class SpecifiedLineTradeAgreement
{
    protected const XML_NODE = 'ram:SpecifiedLineTradeAgreement';

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
        $this->netPriceProductTradePrice   = $netPriceProductTradePrice;
        $this->grossPriceProductTradePrice = null;
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
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->grossPriceProductTradePrice instanceof GrossPriceProductTradePrice) {
            $currentNode->appendChild($this->grossPriceProductTradePrice->toXML($document));
        }

        $currentNode->appendChild($this->netPriceProductTradePrice->toXML($document));

        return $currentNode;
    }
}
