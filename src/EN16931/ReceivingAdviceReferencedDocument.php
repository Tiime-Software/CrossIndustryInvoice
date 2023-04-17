<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\Reference\ReceivingAdviceReference;

/**
 * BT-15-00.
 */
class ReceivingAdviceReferencedDocument
{
    /**
     * BT-15.
     */
    private ReceivingAdviceReference $issuerAssignedID;

    public function __construct(ReceivingAdviceReference $issuerAssignedID)
    {
        $this->issuerAssignedID = $issuerAssignedID;
    }

    public function getIssuerAssignedID(): ReceivingAdviceReference
    {
        return $this->issuerAssignedID;
    }
}
