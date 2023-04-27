<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\PurchaseOrderReference;

/**
 * BT-13-00.
 */
class BuyerOrderReferencedDocument
{
    /**
     * BT-13.
     */
    private PurchaseOrderReference $issuerAssignedIdentifier;

    public function __construct(PurchaseOrderReference $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
    }

    public function getIssuerAssignedIdentifier(): PurchaseOrderReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:BuyerOrderReferencedDocument');
        $currentNode->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $buyerOrderReferencedDocumentElements = $xpath->query('.//ram:BuyerOrderReferencedDocument', $currentElement);

        if (1 !== $buyerOrderReferencedDocumentElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $buyerOrderReferencedDocumentElement */
        $buyerOrderReferencedDocumentElement = $buyerOrderReferencedDocumentElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('.//ram:IssuerAssignedID', $buyerOrderReferencedDocumentElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $issuerAssignedIdentifier = $issuerAssignedIdentifierElements->item(0)->nodeValue;

        return new static(new PurchaseOrderReference($issuerAssignedIdentifier));
    }
}
