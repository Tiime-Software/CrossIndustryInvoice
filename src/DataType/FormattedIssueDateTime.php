<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-26-00.
 */
class FormattedIssueDateTime
{
    /**
     * BT-26.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-26-0.
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
        $element = $document->createElement('ram:FormattedIssueDateTime');

        $dateTimeElement = $document->createElement('ram:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', '102');

        $element->appendChild($dateTimeElement);

        return $element;
    }
}
