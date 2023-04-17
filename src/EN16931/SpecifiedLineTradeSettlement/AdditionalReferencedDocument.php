<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement;

use Tiime\EN16931\DataType\Identifier\ObjectIdentifier;
use Tiime\EN16931\DataType\ObjectSchemeCode;

/**
 * BT-128-00.
 */
class AdditionalReferencedDocument
{
    /**
     * BT-128.
     */
    private ObjectIdentifier $issuerAssignedID;

    /**
     * BT-128-0.
     */
    private string $typeCode;

    /**
     * BT-128-1.
     */
    private ?ObjectSchemeCode $referenceTypeCode;

    public function __construct(ObjectIdentifier $issuerAssignedID)
    {
        $this->issuerAssignedID  = $issuerAssignedID;
        $this->typeCode          = '130';
        $this->referenceTypeCode = null;
    }

    public function getIssuerAssignedID(): ObjectIdentifier
    {
        return $this->issuerAssignedID;
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function getReferenceTypeCode(): ?ObjectSchemeCode
    {
        return $this->referenceTypeCode;
    }

    public function setReferenceTypeCode(?ObjectSchemeCode $referenceTypeCode): void
    {
        $this->referenceTypeCode = $referenceTypeCode;
    }
}
