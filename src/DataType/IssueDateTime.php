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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $issueDateTimeElements = $xpath->query('.//ram:IssueDateTime', $currentElement);

        if (1 !== $issueDateTimeElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $issueDateTimeElement */
        $issueDateTimeElement = $issueDateTimeElements->item(0);

        $dateTimeStringElements = $xpath->query('.//udt:DateTimeString', $issueDateTimeElement);

        if (1 !== $dateTimeStringElements->count()) {
            throw new \Exception('Malformed');
        }

        $dateTimeString = $dateTimeStringElements->item(0)->nodeValue;

        $formattedDateTime = \DateTime::createFromFormat('Ymd', $dateTimeString);

        if (!$formattedDateTime) {
            throw new \Exception('Malformed date');
        }

        $formattedDateTime->setTime(0, 0);

        return new static($formattedDateTime);
    }
}
