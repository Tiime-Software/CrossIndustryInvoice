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

    public function setStartDateTime(?StartDateTime $startDateTime): static
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): ?EndDateTime
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?EndDateTime $endDateTime): static
    {
        $this->endDateTime = $endDateTime;

        return $this;
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
