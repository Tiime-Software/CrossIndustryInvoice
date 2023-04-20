<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

class OccurrenceDateTime
{
    /**
     * BT-72.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-72-0.
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
        $element = $document->createElement('ram:OccurrenceDateTime');

        $dateTimeElement = $document->createElement('ram:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', $this->format);

        $element->appendChild($dateTimeElement);

        return $element;
    }
}
