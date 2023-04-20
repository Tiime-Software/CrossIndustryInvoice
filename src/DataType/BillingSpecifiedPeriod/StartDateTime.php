<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;

/**
 * BT-73-00.
 */
class StartDateTime
{
    /**
     * BT-73.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-73-0.
     */
    private string $format;

    public function __construct(\DateTimeInterface $dateTimeString)
    {
        $this->dateTimeString = $dateTimeString;
        $this->format         = '102';
    }

    public function getDateTimeString(): \DateTimeInterface
    {
        return $this->dateTimeString;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:StartDateTime');

        $dateTimeElement = $document->createElement('ram:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', '102');

        $element->appendChild($dateTimeElement);

        return $element;
    }
}
