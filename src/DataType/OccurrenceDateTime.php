<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

class OccurrenceDateTime
{
    protected const XML_NODE = 'ram:OccurrenceDateTime';

    /**
     * BT-72-0.
     */
    private string $format;

    /**
     * @param \DateTimeInterface $dateTimeString - BT-72
     */
    public function __construct(
        private \DateTimeInterface $dateTimeString,
    ) {
        $this->format = '102';
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
        $element = $document->createElement(self::XML_NODE);

        $dateTimeElement = $document->createElement('udt:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', $this->format);

        $element->appendChild($dateTimeElement);

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $occurrenceDateTimeElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $occurrenceDateTimeElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $occurrenceDateTimeElement */
        $occurrenceDateTimeElement = $occurrenceDateTimeElements->item(0);

        $dateTimeStringElements = $xpath->query('./udt:DateTimeString', $occurrenceDateTimeElement);

        if (1 !== $dateTimeStringElements->count()) {
            throw new \Exception('Malformed');
        }

        $dateTimeStringItem = $dateTimeStringElements->item(0);
        $dateTimeString     = $dateTimeStringItem->nodeValue;

        if ('102' !== $dateTimeStringItem->getAttribute('format')) {
            throw new \Exception('Wrong format');
        }

        $formattedDateTime = \DateTime::createFromFormat('Ymd', $dateTimeString);

        if (!$formattedDateTime) {
            throw new \Exception('Malformed date');
        }

        $formattedDateTime->setTime(0, 0);

        return new self($formattedDateTime);
    }
}
