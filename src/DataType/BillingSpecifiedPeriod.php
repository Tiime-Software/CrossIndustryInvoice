<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\BusinessTermsGroup\InvoiceLinePeriod;
use Tiime\EN16931\BusinessTermsGroup\InvoicingPeriod;

/**
 * BG-14.
 */
class BillingSpecifiedPeriod
{
    protected const XML_NODE = 'ram:BillingSpecifiedPeriod';

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
        $element = $document->createElement(self::XML_NODE);

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
        $billingSpecifiedPeriodElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $billingSpecifiedPeriodElements->count()) {
            return null;
        }

        if ($billingSpecifiedPeriodElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $billingSpecifiedPeriodElement */
        $billingSpecifiedPeriodElement = $billingSpecifiedPeriodElements->item(0);

        $startDateTime = StartDateTime::fromXML($xpath, $billingSpecifiedPeriodElement);
        $endDateTime   = EndDateTime::fromXML($xpath, $billingSpecifiedPeriodElement);

        $billingSpecifiedPeriod = new self();

        if ($startDateTime instanceof StartDateTime) {
            $billingSpecifiedPeriod->setStartDateTime($startDateTime);
        }

        if ($endDateTime instanceof EndDateTime) {
            $billingSpecifiedPeriod->setEndDateTime($endDateTime);
        }

        return $billingSpecifiedPeriod;
    }

    public static function fromEN16931(InvoicingPeriod|InvoiceLinePeriod $period): static
    {
        $startDateTime = $period->getStartDate() instanceof \DateTimeInterface ? new StartDateTime($period->getStartDate()) : null;
        $endDateTime   = $period->getEndDate() instanceof \DateTimeInterface ? new EndDateTime($period->getEndDate()) : null;

        return (new self())
            ->setStartDateTime($startDateTime)
            ->setEndDateTime($endDateTime);
    }
}
