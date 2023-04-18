<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-7-00.
 */
class TaxPointDate
{
    /**
     * BT-7.
     */
    private \DateTimeInterface $dateString;

    /**
     * BT-7-0.
     */
    private readonly string $format;

    public function __construct(\DateTimeInterface $dateString)
    {
        $this->dateString = $dateString;
        $this->format     = '102';
    }

    public function getDateString(): \DateTimeInterface
    {
        return $this->dateString;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
