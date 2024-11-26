<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\Codelist\ReferenceQualifierCodeUNTDID1153;
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
    private ?ReferenceQualifierCodeUNTDID1153 $referenceTypeCode;

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

    public function getReferenceTypeCode(): ?ReferenceQualifierCodeUNTDID1153
    {
        return $this->referenceTypeCode;
    }

    public function setReferenceTypeCode(?ReferenceQualifierCodeUNTDID1153 $referenceTypeCode): static
    {
        $this->referenceTypeCode = $referenceTypeCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));
        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode));

        if ($this->referenceTypeCode instanceof ReferenceQualifierCodeUNTDID1153) {
            $element->appendChild($document->createElement('ram:ReferenceTypeCode', $this->referenceTypeCode->value));
        }

        return $element;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): ?self
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
            $referenceTypeCode = ReferenceQualifierCodeUNTDID1153::tryFrom($referenceTypeCodeElements->item(0)->nodeValue);

            if (!$referenceTypeCode instanceof ReferenceQualifierCodeUNTDID1153) {
                throw new \Exception('Wrong ReferenceTypeCode');
            }

            $additionalReferencedDocumentInvoicedObjectIdentifier->setReferenceTypeCode($referenceTypeCode);
        }

        return $additionalReferencedDocumentInvoicedObjectIdentifier;
    }
}
