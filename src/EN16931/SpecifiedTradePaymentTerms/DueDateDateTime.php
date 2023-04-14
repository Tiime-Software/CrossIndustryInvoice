<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedTradePaymentTerms;

/**
 * BT-9-00.
 */
class DueDateDateTime
{
    /**
     * BT-9.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-9-0.
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
