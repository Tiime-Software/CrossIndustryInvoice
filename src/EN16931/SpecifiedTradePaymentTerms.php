<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\SpecifiedTradePaymentTerms\DueDateDateTime;
use Tiime\EN16931\DataType\Identifier\MandateReferenceIdentifier;

/**
 * BT-20-00.
 */
class SpecifiedTradePaymentTerms
{
    /**
     * BT-20.
     */
    private ?string $description;

    /**
     * BT-9-00.
     */
    private DueDateDateTime $dueDateDateTime;

    /**
     * BT-89.
     */
    private ?MandateReferenceIdentifier $directDebitMandateID;

    public function __construct(DueDateDateTime $dueDateDateTime)
    {
        $this->dueDateDateTime      = $dueDateDateTime;
        $this->description          = null;
        $this->directDebitMandateID = null;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDueDateDateTime(): DueDateDateTime
    {
        return $this->dueDateDateTime;
    }

    public function getDirectDebitMandateID(): ?MandateReferenceIdentifier
    {
        return $this->directDebitMandateID;
    }

    public function setDirectDebitMandateID(?MandateReferenceIdentifier $directDebitMandateID): void
    {
        $this->directDebitMandateID = $directDebitMandateID;
    }
}
