<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;

use Tiime\EN16931\DataType\BinaryObject;
use Tiime\EN16931\DataType\Identifier\ObjectIdentifier;

/**
 * BT-18-00.
 */
class AdditionalReferencedDocumentInvoicedObjectIdentifier
{
    /**
     * BT-18.
     */
    private ObjectIdentifier $issuerAssignedIdentifier;

    /**
     * BT-124.
     */
    private ?string $uriIdentifier;

    /**
     * BT-18-0.
     */
    private string $typeCode;

    /**
     * BT-18-1.
     */
    private ?string $referenceTypeCode;

    /**
     * BT-123.
     */
    private ?string $name;

    /**
     * BT-125.
     */
    private ?BinaryObject $attachmentBinaryObject;

    public function __construct(ObjectIdentifier $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
        $this->typeCode                 = '130';
        $this->referenceTypeCode        = null;
        $this->uriIdentifier            = null;
        $this->name                     = null;
        $this->attachmentBinaryObject   = null;
    }

    public function getIssuerAssignedIdentifier(): ObjectIdentifier
    {
        return $this->issuerAssignedIdentifier;
    }

    public function getUriIdentifier(): ?string
    {
        return $this->uriIdentifier;
    }

    public function setUriIdentifier(?string $uriIdentifier): static
    {
        $this->uriIdentifier = $uriIdentifier;

        return $this;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAttachmentBinaryObject(): ?BinaryObject
    {
        return $this->attachmentBinaryObject;
    }

    public function setAttachmentBinaryObject(?BinaryObject $attachmentBinaryObject): static
    {
        $this->attachmentBinaryObject = $attachmentBinaryObject;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:AdditionalReferencedDocument');

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        if (\is_string($this->uriIdentifier)) {
            $element->appendChild($document->createElement('ram:URIID', $this->uriIdentifier));
        }

        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode));

        if (\is_string($this->referenceTypeCode)) {
            $element->appendChild($document->createElement('ram:ReferenceTypeCode', $this->referenceTypeCode));
        }

        if (\is_string($this->name)) {
            $element->appendChild($document->createElement('ram:Name', $this->name));
        }

        if ($this->attachmentBinaryObject instanceof BinaryObject) {
            $binaryObjectElement = $document->createElement('ram:AttachmentBinaryObject', $this->attachmentBinaryObject->content);

            $binaryObjectElement->setAttribute('mimeCode', $this->attachmentBinaryObject->mimeCode->value);
            $binaryObjectElement->setAttribute('filename', $this->attachmentBinaryObject->filename);

            $element->appendChild($binaryObjectElement);
        }

        return $element;
    }
}
