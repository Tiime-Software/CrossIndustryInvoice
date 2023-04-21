<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BT-134-00.
 */
class StartDateTime
{
    /**
     * BT-134.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-134-0.
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
        $dateTimeElement->setAttribute('format', $this->format);

        $element->appendChild($dateTimeElement);

        return $element;
    }
}
