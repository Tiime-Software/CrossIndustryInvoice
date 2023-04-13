<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

/**
 * BT-72-01.
 */
class OccurenceDateTime
{
    /**
     * BT-72.
     */
    private \DateTimeInterface $dateTime;

    /**
     * BT-72-0.
     */
    private readonly string $dateFormat;
}
