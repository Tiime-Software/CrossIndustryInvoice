<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;

/**
 * BT-16-00.
 */
class DespatchAdviceReferencedDocument
{
    /**
     * BT-16.
     */
    private DespatchAdviceReference $issuerAssignedID;

    public function __construct(DespatchAdviceReference $issuerAssignedID)
    {
        $this->issuerAssignedID = $issuerAssignedID;
    }

    public function getIssuerAssignedID(): DespatchAdviceReference
    {
        return $this->issuerAssignedID;
    }
}
