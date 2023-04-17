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
}
