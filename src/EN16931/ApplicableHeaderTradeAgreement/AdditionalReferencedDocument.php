<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;

use Tiime\EN16931\DataType\BinaryObject;
use Tiime\EN16931\DataType\Reference\SupportingDocumentReference;

/**
 * BG-24.
 */
class AdditionalReferencedDocument
{
    /**
     * BT-122.
     */
    private SupportingDocumentReference $issuerAssignedID;

    /**
     * BT-124.
     */
    private ?string $uriID;

    /**
     * BT-122-0.
     */
    private string $typeCode;

    /**
     * BT-123.
     */
    private ?string $name;

    /**
     * BT-125.
     */
    private ?BinaryObject $attachmentBinaryObject;

    public function __construct(SupportingDocumentReference $issuerAssignedID)
    {
        $this->issuerAssignedID       = $issuerAssignedID;
        $this->typeCode               = '916';
        $this->uriID                  = null;
        $this->name                   = null;
        $this->attachmentBinaryObject = null;
    }

    public function getIssuerAssignedID(): SupportingDocumentReference
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
