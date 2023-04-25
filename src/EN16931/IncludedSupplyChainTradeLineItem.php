<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeDelivery;

/**
 * BG-25.
 */
class IncludedSupplyChainTradeLineItem
{
    /**
     * BT-126-00.
     */
    private AssociatedDocumentLineDocument $associatedDocumentLineDocument;

    /**
     * BG-31.
     */
    private SpecifiedTradeProduct $specifiedTradeProduct;

    /**
     * BG-29.
     */
    private SpecifiedLineTradeAgreement $specifiedLineTradeAgreement;

    /**
     * BT-129-00.
     */
    private SpecifiedLineTradeDelivery $specifiedLineTradeDelivery;

    /**
     * BG-30-00.
     */
    private SpecifiedLineTradeSettlement $specifiedLineTradeSettlement;

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
        $element = $document->createElement('ram:IncludedSupplyChainTradeLineItem');

        $element->appendChild($this->associatedDocumentLineDocument->toXML($document));
        $element->appendChild($this->specifiedTradeProduct->toXML($document));
        $element->appendChild($this->specifiedLineTradeAgreement->toXML($document));
        $element->appendChild($this->specifiedLineTradeDelivery->toXML($document));
        $element->appendChild($this->specifiedLineTradeSettlement->toXML($document));

        return $element;
    }
}
