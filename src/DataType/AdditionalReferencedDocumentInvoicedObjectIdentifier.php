<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\ObjectIdentifier;

/**
 * BT-18-00.
 */
class AdditionalReferencedDocumentInvoicedObjectIdentifier
{
    protected const string XML_NODE = 'ram:AdditionalReferencedDocument';

    /**
     * BT-18-0.
     */
    private string $typeCode;

    /**
     * BT-18-1.
     */
    private ?string $referenceTypeCode;

    /**
     * @param ObjectIdentifier $issuerAssignedIdentifier - BT-18
     */
    public function __construct(
        private readonly ObjectIdentifier $issuerAssignedIdentifier,
    ) {
        $this->typeCode          = '130';
        $this->referenceTypeCode = null;
    }

    public function getIssuerAssignedIdentifier(): ObjectIdentifier
    {
        return $this->issuerAssignedIdentifier;
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function getReferenceTypeCode(): ?string
    {
        return $this->referenceTypeCode;
    }

    public function setReferenceTypeCode(?string $referenceTypeCode): static
    {
        $this->referenceTypeCode = $referenceTypeCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));
        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode));

        if (\is_string($this->referenceTypeCode)) {
            $element->appendChild($document->createElement('ram:ReferenceTypeCode', $this->referenceTypeCode));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $additionalReferencedDocumentInvoicedObjectIdentifierElements = $xpath->query(\sprintf('./%s[ram:TypeCode[text() = \'130\']]', self::XML_NODE), $currentElement);

        if (0 === $additionalReferencedDocumentInvoicedObjectIdentifierElements->count()) {
            return null;
        }

        if ($additionalReferencedDocumentInvoicedObjectIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $additionalReferencedDocumentInvoicedObjectIdentifierElement */
        $additionalReferencedDocumentInvoicedObjectIdentifierElement = $additionalReferencedDocumentInvoicedObjectIdentifierElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('./ram:IssuerAssignedID', $additionalReferencedDocumentInvoicedObjectIdentifierElement);
        $typeCodeElements                 = $xpath->query('./ram:TypeCode', $additionalReferencedDocumentInvoicedObjectIdentifierElement);
        $referenceTypeCodeElements        = $xpath->query('./ram:ReferenceTypeCode', $additionalReferencedDocumentInvoicedObjectIdentifierElement);

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
        $typeCode                 = $typeCodeElements->item(0)->nodeValue;

        if ('130' !== $typeCode) {
            throw new \Exception('Wrong TypeCode');
        }

        $additionalReferencedDocumentInvoicedObjectIdentifier = new self(new ObjectIdentifier($issuerAssignedIdentifier));

        if (1 === $referenceTypeCodeElements->count()) {
            $additionalReferencedDocumentInvoicedObjectIdentifier->setReferenceTypeCode($referenceTypeCodeElements->item(0)->nodeValue);
        }

        return $additionalReferencedDocumentInvoicedObjectIdentifier;
    }
}
