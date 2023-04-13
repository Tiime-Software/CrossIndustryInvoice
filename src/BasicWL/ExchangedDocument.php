<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\InvoiceTypeCode;

/**
 * BT-1-00.
 */
class ExchangedDocument
{
    /**
     * BT-1.
     */
    private InvoiceIdentifier $id;

    /**
     * BT-3.
     */
    private InvoiceTypeCode $invoiceTypeCode;

    /**
     * BT-2-00.
     */
    private IssueDateTime $issueDateTime;

    /**
     * BG-1.
     *
     * @var array<int, IncludedNote>
     */
    private array $includedNotes;
}
