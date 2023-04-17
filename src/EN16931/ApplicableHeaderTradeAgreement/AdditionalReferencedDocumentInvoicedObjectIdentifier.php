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
}
