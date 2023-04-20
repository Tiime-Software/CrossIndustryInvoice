<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;

/**
 * BT-74-00.
 */
class EndDateTime
{
    /**
     * BT-74.
     */
    private \DateTimeInterface $dateTimeString;

    /**
     * BT-74-0.
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
        $element = $document->createElement('ram:EndDateTime');

        $dateTimeElement = $document->createElement('ram:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', $this->format);

        $element->appendChild($dateTimeElement);

        return $element;
    }
}
