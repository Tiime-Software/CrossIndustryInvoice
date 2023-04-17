<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\FormattedIssueDateTime;
use Tiime\EN16931\DataType\Reference\PrecedingInvoiceReference;

/**
 * BG-3.
 */
class InvoiceReferencedDocument
{
    /**
     * BT-25.
     */
    private PrecedingInvoiceReference $issuerAssignedID;

    /**
     * BT-26-00.
     */
    private ?FormattedIssueDateTime $formattedIssueDateTime;

    public function __construct(PrecedingInvoiceReference $issuerAssignedID)
    {
        $this->issuerAssignedID       = $issuerAssignedID;
        $this->formattedIssueDateTime = null;
    }

    public function getIssuerAssignedID(): PrecedingInvoiceReference
    {
        return $this->issuerAssignedID;
    }

    public function getFormattedIssueDateTime(): ?FormattedIssueDateTime
    {
        return $this->formattedIssueDateTime;
    }

    public function setFormattedIssueDateTime(?FormattedIssueDateTime $formattedIssueDateTime): void
    {
        $this->formattedIssueDateTime = $formattedIssueDateTime;
    }
}
