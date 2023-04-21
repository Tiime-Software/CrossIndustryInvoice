<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement;

use Tiime\CrossIndustryInvoice\EN16931\EndDateTime;
use Tiime\CrossIndustryInvoice\EN16931\StartDateTime;

/**
 * BG-26.
 */
class BillingSpecifiedPeriod
{
    /**
     * BT-134-00.
     */
    private ?StartDateTime $startDateTime;

    /**
     * BT-135-00.
     */
    private ?EndDateTime $endDateTime;

    public function __construct()
    {
    }

    public function getStartDateTime(): ?StartDateTime
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(?StartDateTime $startDateTime): void
    {
        $this->startDateTime = $startDateTime;
    }

    public function getEndDateTime(): ?EndDateTime
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?EndDateTime $endDateTime): void
    {
        $this->endDateTime = $endDateTime;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:BillingSpecifiedPeriod');

        if ($this->startDateTime instanceof StartDateTime) {
            $element->appendChild($this->startDateTime->toXML($document));
        }

        if ($this->endDateTime instanceof EndDateTime) {
            $element->appendChild($this->endDateTime->toXML($document));
        }

        return $element;
    }
}
