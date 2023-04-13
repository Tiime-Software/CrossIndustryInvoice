<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

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
}
