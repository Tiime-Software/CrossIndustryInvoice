<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\DocumentIncludedNote;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\InvoiceTypeCode;

/**
 * BT-1-00.
 */
class ExchangedDocument extends \Tiime\CrossIndustryInvoice\DataType\Minimum\ExchangedDocument
{
    /**
     * BG-1.
     *
     * @var array<int, DocumentIncludedNote>
     */
    private array $includedNotes;

    public function __construct(InvoiceIdentifier $id, InvoiceTypeCode $typeCode, IssueDateTime $issueDateTime)
    {
        parent::__construct($id, $typeCode, $issueDateTime);
        $this->includedNotes = [];
    }

    public function getIncludedNotes(): array
    {
        return $this->includedNotes;
    }

    public function setIncludedNotes(array $includedNotes): void
    {
        $tmpIncludedNotes = [];

        foreach ($includedNotes as $includedNote) {
            if (!$includedNote instanceof DocumentIncludedNote) {
                throw new \TypeError();
            }
            $tmpIncludedNotes[] = $includedNote;
        }
        $this->includedNotes = $tmpIncludedNotes;
    }
}