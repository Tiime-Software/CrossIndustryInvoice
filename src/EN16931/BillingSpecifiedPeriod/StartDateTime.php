<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\BillingSpecifiedPeriod;

/**
 * BT-73-00.
 */
class StartDateTime
{
    /**
     * BT-73.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-73-0.
     */
    private string $format;

    public function __construct(\DateTimeInterface $dateTimeString)
    {
        $this->dateTimeString = $dateTimeString;
        $this->format         = '102';
    }

    public function getDateTimeString(): \DateTimeInterface
    {
        return $this->dateTimeString;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
