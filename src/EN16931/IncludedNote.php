<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\InvoiceNoteCode;

/**
 * BG-1.
 */
class IncludedNote
{
    /**
     * BT-22.
     */
    private string $content;

    /**
     * BT-21.
     */
    private ?InvoiceNoteCode $subjectCode;

    public function __construct(string $content)
    {
        $this->content     = $content;
        $this->subjectCode = null;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSubjectCode(): ?InvoiceNoteCode
    {
        return $this->subjectCode;
    }

    public function setSubjectCode(?InvoiceNoteCode $subjectCode): void
    {
        $this->subjectCode = $subjectCode;
    }
}
