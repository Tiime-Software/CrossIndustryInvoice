<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;

use Tiime\EN16931\DataType\Reference\SalesOrderReference;

/**
 * BT-14-00.
 */
class SellerOrderReferencedDocument
{
    /**
     * BT-14.
     */
    private SalesOrderReference $issuerAssignedID;
}
