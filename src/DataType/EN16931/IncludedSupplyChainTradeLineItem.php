<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeDelivery;
use Tiime\EN16931\BusinessTermsGroup\InvoiceLine;

/**
 * BG-25.
 */
class IncludedSupplyChainTradeLineItem extends \Tiime\CrossIndustryInvoice\DataType\Basic\IncludedSupplyChainTradeLineItem
{
    public function __construct(
        AssociatedDocumentLineDocument $associatedDocumentLineDocument,
        SpecifiedTradeProduct $specifiedTradeProduct,
        SpecifiedLineTradeAgreement $specifiedLineTradeAgreement,
        SpecifiedLineTradeDelivery $specifiedLineTradeDelivery,
        SpecifiedLineTradeSettlement $specifiedLineTradeSettlement
    ) {
        parent::__construct(
            $associatedDocumentLineDocument,
            $specifiedTradeProduct,
            $specifiedLineTradeAgreement,
            $specifiedLineTradeDelivery,
            $specifiedLineTradeSettlement
        );
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
        $includedSupplyChainTradeLineItemElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

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

    public static function fromEN16931(InvoiceLine $invoiceLine): self
    {
        return new self(
            AssociatedDocumentLineDocument::fromEN16931($invoiceLine),
            SpecifiedTradeProduct::fromEN16931($invoiceLine->getItemInformation()),
            SpecifiedLineTradeAgreement::fromEN16931($invoiceLine),
            SpecifiedLineTradeDelivery::fromEN16931($invoiceLine),
            SpecifiedLineTradeSettlement::fromEN16931($invoiceLine),
        );
    }
}
