<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\TenderOrLotReference;

/**
 * BT-17-00.
 */
class AdditionalReferencedDocumentTenderOrLotReference
{
    protected const string XML_NODE = 'ram:AdditionalReferencedDocument';

    /**
     * BT-17-0.
     */
    private string $typeCode;

    /**
     * @param TenderOrLotReference $issuerAssignedIdentifier - BT-17
     */
    public function __construct(
        private readonly TenderOrLotReference $issuerAssignedIdentifier,
    ) {
        $this->typeCode = '50';
    }

    public function getIssuerAssignedIdentifier(): TenderOrLotReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));
        $currentNode->appendChild($document->createElement('ram:TypeCode', $this->typeCode));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $additionalReferencedDocumentTenderOrLotReferenceElements = $xpath->query(\sprintf('./%s[ram:TypeCode[text() = \'50\']]', self::XML_NODE), $currentElement);

        if (0 === $additionalReferencedDocumentTenderOrLotReferenceElements->count()) {
            return null;
        }

        if ($additionalReferencedDocumentTenderOrLotReferenceElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $additionalReferencedDocumentTenderOrLotReferenceElement */
        $additionalReferencedDocumentTenderOrLotReferenceElement = $additionalReferencedDocumentTenderOrLotReferenceElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('./ram:IssuerAssignedID', $additionalReferencedDocumentTenderOrLotReferenceElement);
        $typeCodeElements                 = $xpath->query('./ram:TypeCode', $additionalReferencedDocumentTenderOrLotReferenceElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $typeCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        $issuerAssignedIdentifier = $issuerAssignedIdentifierElements->item(0)->nodeValue;
        $typeCode                 = $typeCodeElements->item(0)->nodeValue;

        if ('50' !== $typeCode) {
            throw new \Exception('Wrong TypeCode');
        }

        return new self(new TenderOrLotReference($issuerAssignedIdentifier));
    }
}
