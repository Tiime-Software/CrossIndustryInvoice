<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\ObjectIdentifier;
use Tiime\EN16931\DataType\ObjectSchemeCode;

/**
 * BT-128-00.
 */
class AdditionalReferencedDocumentInvoiceLineObjectIdentifier
{
    protected const XML_NODE = 'ram:AdditionalReferencedDocument';

    /**
     * BT-128.
     */
    private ObjectIdentifier $issuerAssignedIdentifier;

    /**
     * BT-128-0.
     */
    private string $typeCode;

    /**
     * BT-128-1.
     */
    private ?ObjectSchemeCode $referenceTypeCode;

    public function __construct(ObjectIdentifier $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
        $this->typeCode                 = '130';
        $this->referenceTypeCode        = null;
    }

    public function getIssuerAssignedIdentifier(): ObjectIdentifier
    {
        return $this->issuerAssignedIdentifier;
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function getReferenceTypeCode(): ?ObjectSchemeCode
    {
        return $this->referenceTypeCode;
    }

    public function setReferenceTypeCode(?ObjectSchemeCode $referenceTypeCode): static
    {
        $this->referenceTypeCode = $referenceTypeCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));
        $currentNode->appendChild($document->createElement('ram:TypeCode', $this->typeCode));

        if ($this->referenceTypeCode instanceof ObjectSchemeCode) {
            $currentNode->appendChild($document->createElement('ram:ReferenceTypeCode', $this->referenceTypeCode->value));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $additionalReferencedDocumentElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $additionalReferencedDocumentElements->count()) {
            return null;
        }

        if ($additionalReferencedDocumentElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $additionalReferencedDocumentElement */
        $additionalReferencedDocumentElement = $additionalReferencedDocumentElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('.//ram:IssuerAssignedID', $additionalReferencedDocumentElement);
        $typeCodeElements                 = $xpath->query('.//ram:TypeCode', $additionalReferencedDocumentElement);
        $referenceTypeCodeElements        = $xpath->query('.//ram:ReferenceTypeCode', $additionalReferencedDocumentElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $typeCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($referenceTypeCodeElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $issuerAssignedIdentifier = $issuerAssignedIdentifierElements->item(0)->nodeValue;

        if ('130' !== $typeCodeElements->item(0)->nodeValue) {
            throw new \Exception('Wrong TypeCode');
        }

        $additionalReferencedDocument = new self(new ObjectIdentifier($issuerAssignedIdentifier));

        if (1 === $referenceTypeCodeElements->count()) {
            $additionalReferencedDocument->setReferenceTypeCode($referenceTypeCodeElements->item(0)->nodeValue);
        }

        return $additionalReferencedDocument;
    }
}
