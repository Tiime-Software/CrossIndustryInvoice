<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\AssociatedDocumentLineDocument\IncludedNote;
use Tiime\EN16931\DataType\Identifier\InvoiceLineIdentifier;

/**
 * BT-126-00.
 */
class AssociatedDocumentLineDocument
{
    /**
     * BT-126.
     */
    private InvoiceLineIdentifier $lineID;

    /**
     * BT-127-00.
     */
    private ?IncludedNote $includedNote;

    public function __construct(InvoiceLineIdentifier $lineID)
    {
        $this->lineID = $lineID;
    }

    public function getLineID(): InvoiceLineIdentifier
    {
        return $this->lineID;
    }

    public function getIncludedNote(): ?IncludedNote
    {
        return $this->includedNote;
    }

    public function setIncludedNote(?IncludedNote $includedNote): void
    {
        $this->includedNote = $includedNote;
    }
}
