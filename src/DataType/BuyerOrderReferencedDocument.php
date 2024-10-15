<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\PurchaseOrderReference;

/**
 * BT-13-00.
 */
class BuyerOrderReferencedDocument
{
    protected const string XML_NODE = 'ram:BuyerOrderReferencedDocument';

    /**
     * @param PurchaseOrderReference $issuerAssignedIdentifier - BT-13
     */
    public function __construct(
        private readonly PurchaseOrderReference $issuerAssignedIdentifier,
    ) {
    }

    public function getIssuerAssignedIdentifier(): PurchaseOrderReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $buyerOrderReferencedDocumentElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $buyerOrderReferencedDocumentElements->count()) {
            return null;
        }

        if (1 !== $buyerOrderReferencedDocumentElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $buyerOrderReferencedDocumentElement */
        $buyerOrderReferencedDocumentElement = $buyerOrderReferencedDocumentElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('./ram:IssuerAssignedID', $buyerOrderReferencedDocumentElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $issuerAssignedIdentifier = $issuerAssignedIdentifierElements->item(0)->nodeValue;

        return new self(new PurchaseOrderReference($issuerAssignedIdentifier));
    }
}
