<?php

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;

/**
 * BG-25.
 */
class IncludedSupplyChainTradeLineItem
{
    protected const XML_NODE = 'ram:IncludedSupplyChainTradeLineItem';

    /**
     * @param AssociatedDocumentLineDocument $associatedDocumentLineDocument - BT-126-00
     * @param SpecifiedTradeProduct          $specifiedTradeProduct          - BG-31
     * @param SpecifiedLineTradeAgreement    $specifiedLineTradeAgreement    - BG-29
     * @param SpecifiedLineTradeDelivery     $specifiedLineTradeDelivery     - BT-129-00
     * @param SpecifiedLineTradeSettlement   $specifiedLineTradeSettlement   - BG-30-00
     */
    public function __construct(
        protected AssociatedDocumentLineDocument $associatedDocumentLineDocument,
        protected SpecifiedTradeProduct $specifiedTradeProduct,
        protected SpecifiedLineTradeAgreement $specifiedLineTradeAgreement,
        protected SpecifiedLineTradeDelivery $specifiedLineTradeDelivery,
        protected SpecifiedLineTradeSettlement $specifiedLineTradeSettlement,
    ) {
    }

    public function getAssociatedDocumentLineDocument(): AssociatedDocumentLineDocument
    {
        return $this->associatedDocumentLineDocument;
    }

    public function getSpecifiedTradeProduct(): SpecifiedTradeProduct
    {
        return $this->specifiedTradeProduct;
    }

    public function getSpecifiedLineTradeAgreement(): SpecifiedLineTradeAgreement
    {
        return $this->specifiedLineTradeAgreement;
    }

    public function getSpecifiedLineTradeDelivery(): SpecifiedLineTradeDelivery
    {
        return $this->specifiedLineTradeDelivery;
    }

    public function getSpecifiedLineTradeSettlement(): SpecifiedLineTradeSettlement
    {
        return $this->specifiedLineTradeSettlement;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->associatedDocumentLineDocument->toXML($document));
        $currentNode->appendChild($this->specifiedTradeProduct->toXML($document));
        $currentNode->appendChild($this->specifiedLineTradeAgreement->toXML($document));
        $currentNode->appendChild($this->specifiedLineTradeDelivery->toXML($document));
        $currentNode->appendChild($this->specifiedLineTradeSettlement->toXML($document));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        $includedSupplyChainTradeLineItemElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $includedSupplyChainTradeLineItemElements->count()) {
            return [];
        }

        $includedSupplyChainTradeLineItems = [];

        foreach ($includedSupplyChainTradeLineItemElements as $includedSupplyChainTradeLineItemElement) {
            $associatedDocumentLineDocument = AssociatedDocumentLineDocument::fromXML($xpath, $includedSupplyChainTradeLineItemElement);
            $specifiedTradeProduct          = SpecifiedTradeProduct::fromXML($xpath, $includedSupplyChainTradeLineItemElement);
            $specifiedLineTradeAgreement    = SpecifiedLineTradeAgreement::fromXML($xpath, $includedSupplyChainTradeLineItemElement);
            $specifiedLineTradeDelivery     = SpecifiedLineTradeDelivery::fromXML($xpath, $includedSupplyChainTradeLineItemElement);
            $specifiedLineTradeSettlement   = SpecifiedLineTradeSettlement::fromXML($xpath, $includedSupplyChainTradeLineItemElement);

            $includedSupplyChainTradeLineItems[] = new self($associatedDocumentLineDocument, $specifiedTradeProduct, $specifiedLineTradeAgreement, $specifiedLineTradeDelivery, $specifiedLineTradeSettlement);
        }

        return $includedSupplyChainTradeLineItems;
    }
}
