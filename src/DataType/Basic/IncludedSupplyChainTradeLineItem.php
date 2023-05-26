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
     * BT-126-00.
     */
    protected AssociatedDocumentLineDocument $associatedDocumentLineDocument;

    /**
     * BG-31.
     */
    protected SpecifiedTradeProduct $specifiedTradeProduct;

    /**
     * BG-29.
     */
    protected SpecifiedLineTradeAgreement $specifiedLineTradeAgreement;

    /**
     * BT-129-00.
     */
    protected SpecifiedLineTradeDelivery $specifiedLineTradeDelivery;

    /**
     * BG-30-00.
     */
    protected SpecifiedLineTradeSettlement $specifiedLineTradeSettlement;

    public function __construct(
        AssociatedDocumentLineDocument $associatedDocumentLineDocument,
        SpecifiedTradeProduct $specifiedTradeProduct,
        SpecifiedLineTradeAgreement $specifiedLineTradeAgreement,
        SpecifiedLineTradeDelivery $specifiedLineTradeDelivery,
        SpecifiedLineTradeSettlement $specifiedLineTradeSettlement
    ) {
        $this->associatedDocumentLineDocument = $associatedDocumentLineDocument;
        $this->specifiedTradeProduct          = $specifiedTradeProduct;
        $this->specifiedLineTradeAgreement    = $specifiedLineTradeAgreement;
        $this->specifiedLineTradeDelivery     = $specifiedLineTradeDelivery;
        $this->specifiedLineTradeSettlement   = $specifiedLineTradeSettlement;
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
        $includedSupplyChainTradeLineItemElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

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
