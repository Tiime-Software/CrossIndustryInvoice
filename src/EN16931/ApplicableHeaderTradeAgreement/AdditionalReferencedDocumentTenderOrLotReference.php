<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;

use Tiime\EN16931\DataType\BinaryObject;
use Tiime\EN16931\DataType\Reference\TenderOrLotReference;

/**
 * BT-17-00.
 */
class AdditionalReferencedDocumentTenderOrLotReference
{
    /**
     * BT-17.
     */
    private TenderOrLotReference $issuerAssignedID;

    /**
     * BT-124.
     */
    private ?string $uriID;

    /**
     * BT-17-0.
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

    public function __construct(TenderOrLotReference $issuerAssignedID)
    {
        $this->issuerAssignedID       = $issuerAssignedID;
        $this->typeCode               = '50';
        $this->uriID                  = null;
        $this->name                   = null;
        $this->attachmentBinaryObject = null;
    }

    public function getIssuerAssignedID(): TenderOrLotReference
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

        if (is_string($this->uriID)) {
            $element->appendChild($document->createElement('ram:URIID', $this->uriID));
        }

        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode));

        if (is_string($this->name)) {
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
