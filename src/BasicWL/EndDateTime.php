<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

/**
 * BT-74-00.
 */
class EndDateTime
{
    /**
     * BT-74.
     */
    private \DateTimeInterface $dateTime;

    /**
     * BT-74-0.
     */
    private readonly string $format;
}
