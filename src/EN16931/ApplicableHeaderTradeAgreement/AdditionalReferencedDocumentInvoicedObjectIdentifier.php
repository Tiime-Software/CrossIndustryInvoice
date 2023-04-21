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
    private ObjectIdentifier $issuerAssignedID;

    /**
     * BT-124.
     */
    private ?string $uriID;

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

    public function __construct(ObjectIdentifier $issuerAssignedID)
    {
        $this->issuerAssignedID       = $issuerAssignedID;
        $this->typeCode               = '130';
        $this->referenceTypeCode      = null;
        $this->uriID                  = null;
        $this->name                   = null;
        $this->attachmentBinaryObject = null;
    }

    public function getIssuerAssignedID(): ObjectIdentifier
    {
        return $this->issuerAssignedID;
    }

    public function getUriID(): ?string
    {
        return $this->uriID;
    }

    public function setUriID(?string $uriID): void
    {
        $this->uriID = $uriID;
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function getReferenceTypeCode(): ?string
    {
        return $this->referenceTypeCode;
    }

    public function setReferenceTypeCode(?string $referenceTypeCode): void
    {
        $this->referenceTypeCode = $referenceTypeCode;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getAttachmentBinaryObject(): ?BinaryObject
    {
        return $this->attachmentBinaryObject;
    }

    public function setAttachmentBinaryObject(?BinaryObject $attachmentBinaryObject): void
    {
        $this->attachmentBinaryObject = $attachmentBinaryObject;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:AdditionalReferencedDocument');

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedID->value));

        if (\is_string($this->uriID)) {
            $element->appendChild($document->createElement('ram:URIID', $this->uriID));
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
