<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;

/**
 * BT-16-00.
 */
class DespatchAdviceReferencedDocument
{
    protected const string XML_NODE = 'ram:DespatchAdviceReferencedDocument';

    /**
     * @param DespatchAdviceReference $issuerAssignedIdentifier - BT-16
     */
    public function __construct(
        private readonly DespatchAdviceReference $issuerAssignedIdentifier,
    ) {
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

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): ?self
    {
        $despatchAdviceReferencedDocumentElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

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
