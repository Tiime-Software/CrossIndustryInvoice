<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;

use Tiime\EN16931\DataType\Reference\PurchaseOrderReference;

/**
 * BT-13-00.
 */
class BuyerOrderReferencedDocument
{
    /**
     * BT-13.
     */
    private PurchaseOrderReference $issuerAssignedID;
}
