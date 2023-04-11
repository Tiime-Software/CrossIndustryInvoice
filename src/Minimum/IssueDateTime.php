<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

class IssueDateTime
{
    /**
     * BT-2.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-2-0.
     */
    private readonly string $dateFormat;

    public function __construct(\DateTimeInterface $dateTimeString)
    {
        $this->dateTimeString = $dateTimeString;
        $this->dateFormat     = '102';
    }

    public function getDateTimeString(): \DateTimeInterface
    {
        return $this->dateTimeString;
    }

    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }
}
