<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod\EndDateTime;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod\StartDateTime;

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

    public function __construct()
    {
        $this->startDateTime = null;
        $this->endDateTime   = null;
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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        // todo
    }
}
