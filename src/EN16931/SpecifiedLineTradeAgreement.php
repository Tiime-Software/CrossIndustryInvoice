<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\Basic\GrossPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\DataType\NetPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeAgreement\BuyerOrderReferencedDocument;
use Tiime\EN16931\BusinessTermsGroup\InvoiceLine;
use Tiime\EN16931\DataType\Reference\PurchaseOrderLineReference;

/**
 * BG-29.
 */
class SpecifiedLineTradeAgreement extends \Tiime\CrossIndustryInvoice\Basic\SpecifiedLineTradeAgreement
{
    protected const XML_NODE = 'ram:SpecifiedLineTradeAgreement';

    /**
     * BT-132-00.
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
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->buyerOrderReferencedDocument instanceof BuyerOrderReferencedDocument) {
            $currentNode->appendChild($this->buyerOrderReferencedDocument->toXML($document));
        }

        if ($this->getGrossPriceProductTradePrice() instanceof GrossPriceProductTradePrice) {
            $currentNode->appendChild($this->getGrossPriceProductTradePrice()->toXML($document));
        }

        $currentNode->appendChild($this->getNetPriceProductTradePrice()->toXML($document));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $specifiedLineTradeAgreementElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $specifiedLineTradeAgreementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedLineTradeAgreementElement */
        $specifiedLineTradeAgreementElement = $specifiedLineTradeAgreementElements->item(0);

        $buyerOrderReferencedDocument = BuyerOrderReferencedDocument::fromXML($xpath, $specifiedLineTradeAgreementElement);
        $grossPriceProductTradePrice  = GrossPriceProductTradePrice::fromXML($xpath, $specifiedLineTradeAgreementElement);
        $netPriceProductTradePrice    = NetPriceProductTradePrice::fromXML($xpath, $specifiedLineTradeAgreementElement);

        $specifiedLineTradeAgreement = new self($netPriceProductTradePrice);

        if ($buyerOrderReferencedDocument instanceof BuyerOrderReferencedDocument) {
            $specifiedLineTradeAgreement->setBuyerOrderReferencedDocument($buyerOrderReferencedDocument);
        }

        if ($grossPriceProductTradePrice instanceof GrossPriceProductTradePrice) {
            $specifiedLineTradeAgreement->setGrossPriceProductTradePrice($grossPriceProductTradePrice);
        }

        return $specifiedLineTradeAgreement;
    }

    public static function fromEN16931(InvoiceLine $invoiceLine): static
    {
        $buyerOrderReferencedDocument = $invoiceLine->getReferencedPurchaseOrderLineReference() instanceof PurchaseOrderLineReference
            ? BuyerOrderReferencedDocument::fromEN16931($invoiceLine)
            : null;

        return (new self(NetPriceProductTradePrice::fromEN16931($invoiceLine->getPriceDetails())))
            ->setGrossPriceProductTradePrice(
                \is_float($invoiceLine->getPriceDetails()->getItemGrossPrice())
                    ? GrossPriceProductTradePrice::fromEN16931($invoiceLine->getPriceDetails())
                    : null
            )
            ->setBuyerOrderReferencedDocument($buyerOrderReferencedDocument);
    }
}
