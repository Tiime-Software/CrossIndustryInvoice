<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

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
    private InvoiceTypeCode $typeCode;

    /**
     * BT-2-00.
     */
    private IssueDateTime $issueDateTime;

    public function __construct(InvoiceIdentifier $id, InvoiceTypeCode $typeCode, IssueDateTime $issueDateTime)
    {
        $this->id            = $id;
        $this->typeCode      = $typeCode;
        $this->issueDateTime = $issueDateTime;
    }

    public function getId(): InvoiceIdentifier
    {
        return $this->id;
    }

    public function getTypeCode(): InvoiceTypeCode
    {
        return $this->typeCode;
    }

    public function getIssueDateTime(): IssueDateTime
    {
        return $this->issueDateTime;
    }
}
