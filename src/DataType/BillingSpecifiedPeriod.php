<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod\EndDateTime;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod\StartDateTime;

/**
 * BG-14.
 */
class BillingSpecifiedPeriod
{
    /**
     * BT-73-00.
     */
    private ?StartDateTime $startDateTime;

    /**
     * BT-74-00.
     */
    private ?EndDateTime $endDateTime;

    public function __construct()
    {
        $this->startDateTime = null;
        $this->endDateTime   = null;
    }

    public function getStartDateTime(): ?StartDateTime
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(?StartDateTime $startDateTime): void
    {
        $this->startDateTime = $startDateTime;
    }

    public function getEndDateTime(): ?EndDateTime
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?EndDateTime $endDateTime): void
    {
        $this->endDateTime = $endDateTime;
    }
}