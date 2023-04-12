<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\AssociatedDocumentLineDocument;

/**
 * BT-127-00.
 */
class IncludedNote
{
    /**
     * BT-127.
     */
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
