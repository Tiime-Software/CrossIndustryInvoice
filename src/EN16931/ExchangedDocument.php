<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

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
    private InvoiceTypeCode $typeCode;

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

    public function __construct(InvoiceIdentifier $id, InvoiceTypeCode $typeCode, IssueDateTime $issueDateTime)
    {
        $this->id            = $id;
        $this->typeCode      = $typeCode;
        $this->issueDateTime = $issueDateTime;
        $this->includedNotes = [];
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

    public function getIncludedNotes(): array
    {
        return $this->includedNotes;
    }

    public function setIncludedNotes(array $includedNotes): void
    {
        $tmpIncludedNotes = [];

        foreach ($includedNotes as $includedNote) {
            if (!$includedNote instanceof IncludedNote) {
                throw new \TypeError();
            }
            $tmpIncludedNotes[] = $includedNote;
        }
        $this->includedNotes = $tmpIncludedNotes;
    }
}
