<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\ReceivingAdviceReference;

/**
 * BT-15-00.
 */
class ReceivingAdviceReferencedDocument
{
    protected const XML_NODE = 'ram:ReceivingAdviceReferencedDocument';

    /**
     * BT-15.
     */
    private ReceivingAdviceReference $issuerAssignedIdentifier;

    public function __construct(ReceivingAdviceReference $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
    }

    public function getIssuerAssignedIdentifier(): ReceivingAdviceReference
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
        $receivingAdviceReferencedDocumentElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $receivingAdviceReferencedDocumentElements->count()) {
            return null;
        }

        if ($receivingAdviceReferencedDocumentElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $receivingAdviceReferencedDocumentElement */
        $receivingAdviceReferencedDocumentElement = $receivingAdviceReferencedDocumentElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('./ram:IssuerAssignedID', $receivingAdviceReferencedDocumentElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        return new self(new ReceivingAdviceReference($issuerAssignedIdentifierElements->item(0)->nodeValue));
    }
}
