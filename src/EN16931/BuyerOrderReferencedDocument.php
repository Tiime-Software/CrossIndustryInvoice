<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\Reference\PurchaseOrderLineReference;

/**
 * BT-13-00.
 */
class BuyerOrderReferencedDocument
{
    /**
     * BT-132.
     */
    private ?PurchaseOrderLineReference $lineID;

    public function __construct()
    {
    }

    public function getLineID(): ?PurchaseOrderLineReference
    {
        return $this->lineID;
    }

    public function setLineID(?PurchaseOrderLineReference $lineID): void
    {
        $this->lineID = $lineID;
    }
}
