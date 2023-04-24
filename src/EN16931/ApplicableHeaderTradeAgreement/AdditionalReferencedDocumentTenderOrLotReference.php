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
    private TenderOrLotReference $issuerAssignedIdentifier;

    /**
     * BT-124.
     */
    private ?string $uriIdentifier;

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

    public function __construct(TenderOrLotReference $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
        $this->typeCode                 = '50';
        $this->uriIdentifier            = null;
        $this->name                     = null;
        $this->attachmentBinaryObject   = null;
    }

    public function getIssuerAssignedIdentifier(): TenderOrLotReference
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
