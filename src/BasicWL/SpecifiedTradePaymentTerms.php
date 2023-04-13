<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

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
    private ?DueDateDateTime $dueDateDateTime;

    /**
     * BT-89.
     */
    private ?MandateReferenceIdentifier $directDebitMandateId;
}
