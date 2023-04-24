<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\InvoiceNoteCode;

/**
 * BG-1.
 */
class DocumentIncludedNote
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

    public function setSubjectCode(?InvoiceNoteCode $subjectCode): static
    {
        $this->subjectCode = $subjectCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:IncludedNote');

        $element->appendChild($document->createElement('ram:Content', $this->content));

        if ($this->subjectCode instanceof InvoiceNoteCode) {
            $element->appendChild($document->createElement('ram:SubjectCode', $this->subjectCode->value));
        }

        return $element;
    }
}
