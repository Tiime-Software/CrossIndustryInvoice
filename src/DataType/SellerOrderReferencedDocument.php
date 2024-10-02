<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\SalesOrderReference;

/**
 * BT-14-00.
 */
class SellerOrderReferencedDocument
{
    protected const XML_NODE = 'ram:SellerOrderReferencedDocument';

    /**
     * BT-14.
     */
    private SalesOrderReference $issuerAssignedIdentifier;

    public function __construct(SalesOrderReference $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
    }

    public function getIssuerAssignedIdentifier(): SalesOrderReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function toXML(\DOMDocument $document)
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $sellerOrderReferencedDocumentElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $sellerOrderReferencedDocumentElements->count()) {
            return null;
        }

        if ($sellerOrderReferencedDocumentElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerOrderReferencedDocumentElement */
        $sellerOrderReferencedDocumentElement = $sellerOrderReferencedDocumentElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('./ram:IssuerAssignedID', $sellerOrderReferencedDocumentElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $issuerAssignedIdentifier = $issuerAssignedIdentifierElements->item(0)->nodeValue;

        return new self(new SalesOrderReference($issuerAssignedIdentifier));
    }
}
