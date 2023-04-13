<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

/**
 * BT-73-00.
 */
class StartDateTime
{
    /**
     * BT-73.
     */
    private \DateTimeInterface $dateTime;

    /**
     * BT-73-0.
     */
    private readonly string $format;
}
