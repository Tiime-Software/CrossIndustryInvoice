<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BT-72-00.
 */
class ActualDeliverySupplyChainEvent
{
    /**
     * BT-72-01.
     */
    private OccurenceDateTime $occurenceDateTime;

    public function __construct(OccurenceDateTime $occurenceDateTime)
    {
        $this->occurenceDateTime = $occurenceDateTime;
    }

    public function getOccurenceDateTime(): OccurenceDateTime
    {
        return $this->occurenceDateTime;
    }
}
