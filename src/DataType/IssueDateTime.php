<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

class IssueDateTime
{
    /**
     * BT-2.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-2-0.
     */
    private readonly string $dateFormat;

    public function __construct(\DateTimeInterface $dateTimeString)
    {
        $this->dateTimeString = $dateTimeString;
        $this->dateFormat     = '102';
    }

    public function getDateTimeString(): \DateTimeInterface
    {
        return $this->dateTimeString;
    }

    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:IssueDateTime');

        $dateTimeElement = $document->createElement('udt:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', $this->dateFormat);

        $element->appendChild($dateTimeElement);

        return $element;
    }

    public static function fromXML(\DOMDocument $document): static
    {
        // todo $dateTimeString
        // todo $dateFormat
    }
}
