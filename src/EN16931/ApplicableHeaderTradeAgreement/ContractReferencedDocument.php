<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;

use Tiime\EN16931\DataType\Reference\ContractReference;

/**
 * BT-12-00.
 */
class ContractReferencedDocument
{
    /**
     * BT-12.
     */
    private ?ContractReference $issuerAssignedID;
}
