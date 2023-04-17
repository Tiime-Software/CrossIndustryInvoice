<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\BillingSpecifiedPeriod;

/**
 * BT-74-00.
 */
class EndDateTime
{
    /**
     * BT-74.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-74-0.
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
