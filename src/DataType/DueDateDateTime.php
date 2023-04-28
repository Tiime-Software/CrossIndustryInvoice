<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-9-00.
 */
class DueDateDateTime
{
    /**
     * BT-9.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-9-0.
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
        $element = $document->createElement('ram:DueDateDateTime');

        $dateTimeElement = $document->createElement('ram:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', $this->format);

        $element->appendChild($dateTimeElement);

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        // todo
    }
}
