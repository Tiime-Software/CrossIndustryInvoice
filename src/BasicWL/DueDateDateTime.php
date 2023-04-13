<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

/**
 * BT-9-00.
 */
class DueDateDateTime
{
    /**
     * BT-9.
     */
    private \DateTimeInterface $dateTime;

    /**
     * BT-9-0.
     */
    private readonly string $dateFormat;
}
