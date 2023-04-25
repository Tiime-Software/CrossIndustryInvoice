<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\Basic\GrossPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeAgreement\BuyerOrderReferencedDocument;

/**
 * BG-29.
 */
class SpecifiedLineTradeAgreement extends \Tiime\CrossIndustryInvoice\Basic\SpecifiedLineTradeAgreement
{
    /**
     * BT-13-00.
     */
    private ?BuyerOrderReferencedDocument $buyerOrderReferencedDocument;

    public function __construct(NetPriceProductTradePrice $netPriceProductTradePrice)
    {
        parent::__construct($netPriceProductTradePrice);

        $this->buyerOrderReferencedDocument = null;
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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedLineTradeAgreement');

        if ($this->buyerOrderReferencedDocument instanceof BuyerOrderReferencedDocument) {
            $element->appendChild($this->buyerOrderReferencedDocument->toXML($document));
        }

        if ($this->getGrossPriceProductTradePrice() instanceof GrossPriceProductTradePrice) {
            $element->appendChild($this->getGrossPriceProductTradePrice()->toXML($document));
        }

        $element->appendChild($this->getNetPriceProductTradePrice()->toXML($document));

        return $element;
    }
}
