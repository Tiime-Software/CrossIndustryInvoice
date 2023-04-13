<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\Reference\PrecedingInvoiceReference;

/**
 * BG-3.
 */
class InvoiceReferencedDocument
{
    /**
     * BT-25.
     */
    private PrecedingInvoiceReference $issuerAssignedId;

    /**
     * BT-26-00.
     */
    private ?FormattedIssueDateTime $formattedIssueDateTime;
}
