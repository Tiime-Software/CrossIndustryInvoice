<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

/**
 * BG-14.
 */
class BillingSpecifiedPeriod
{
    /**
     * BT-73-00.
     */
    private ?StartDateTime $startDateTime;

    /**
     * BT-74-00.
     */
    private ?EndDateTime $endDateTime;
}
