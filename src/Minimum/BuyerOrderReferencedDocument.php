<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\DataType\Reference\PurchaseOrderReference;

/**
 * BT-13-00
 */
class BuyerOrderReferencedDocument
{
    /**
     * BT-13
     */
    private PurchaseOrderReference $issuerAssignedID;

    public function __construct(PurchaseOrderReference $issuerAssignedID)
    {
        $this->issuerAssignedID = $issuerAssignedID;
    }

    public function getIssuerAssignedID(): PurchaseOrderReference
    {
        return $this->issuerAssignedID;
    }
}