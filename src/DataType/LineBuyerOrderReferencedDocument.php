<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\BusinessTermsGroup\InvoiceLine;
use Tiime\EN16931\DataType\Reference\PurchaseOrderLineReference;

/**
 * BT-132-00.
 */
class LineBuyerOrderReferencedDocument
{
    protected const XML_NODE = 'ram:BuyerOrderReferencedDocument';

    /**
     * BT-132.
     */
    private ?PurchaseOrderLineReference $lineIdentifier;

    public function __construct()
    {
    }

    public function getLineIdentifier(): ?PurchaseOrderLineReference
    {
        return $this->lineIdentifier;
    }

    public function setLineIdentifier(?PurchaseOrderLineReference $lineIdentifier): static
    {
        $this->lineIdentifier = $lineIdentifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->lineIdentifier instanceof PurchaseOrderLineReference) {
            $currentNode->appendChild($document->createElement('ram:LineID', $this->lineIdentifier->value));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $buyerOrderReferencedDocumentElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $buyerOrderReferencedDocumentElements->count()) {
            return null;
        }

        if ($buyerOrderReferencedDocumentElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $buyerOrderReferencedDocumentElement */
        $buyerOrderReferencedDocumentElement = $buyerOrderReferencedDocumentElements->item(0);

        $lineIdentifierElements = $xpath->query('./ram:LineID', $buyerOrderReferencedDocumentElement);

        if ($lineIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $buyerOrderReferencedDocument = new self();

        if (1 === $lineIdentifierElements->count()) {
            $buyerOrderReferencedDocument->setLineIdentifier(new PurchaseOrderLineReference($lineIdentifierElements->item(0)->nodeValue));
        }

        return $buyerOrderReferencedDocument;
    }

    public static function fromEN16931(InvoiceLine $invoiceLine): self
    {
        return (new self())->setLineIdentifier($invoiceLine->getReferencedPurchaseOrderLineReference());
    }
}
