<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;

/**
 * BT-16-00.
 */
class DespatchAdviceReferencedDocument
{
    protected const XML_NODE = 'ram:DespatchAdviceReferencedDocument';

    /**
     * BT-16.
     */
    private DespatchAdviceReference $issuerAssignedIdentifier;

    public function __construct(DespatchAdviceReference $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
    }

    public function getIssuerAssignedIdentifier(): DespatchAdviceReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $despatchAdviceReferencedDocumentElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $despatchAdviceReferencedDocumentElements->count()) {
            return null;
        }

        if ($despatchAdviceReferencedDocumentElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $despatchAdviceReferencedDocumentElement */
        $despatchAdviceReferencedDocumentElement = $despatchAdviceReferencedDocumentElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('./ram:IssuerAssignedID', $despatchAdviceReferencedDocumentElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $issuerAssignedIdentifier = $issuerAssignedIdentifierElements->item(0)->nodeValue;

        return new self(new DespatchAdviceReference($issuerAssignedIdentifier));
    }
}
