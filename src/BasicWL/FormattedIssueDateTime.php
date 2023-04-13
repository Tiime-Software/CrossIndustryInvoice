<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

/**
 * BT-26-00.
 */
class FormattedIssueDateTime
{
    /**
     * BT-26.
     */
    private \DateTimeInterface $dateTime;

    /**
     * BT-26-0.
     */
    private readonly string $dateFormat;
}
