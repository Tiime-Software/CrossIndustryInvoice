<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-73-00.
 */
class StartDateTime
{
    protected const XML_NODE = 'ram:StartDateTime';

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
        $currentNode = $document->createElement(self::XML_NODE);

        $dateTimeElement = $document->createElement('udt:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', $this->format);

        $currentNode->appendChild($dateTimeElement);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $startDateTimeElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $startDateTimeElements->count()) {
            return null;
        }

        if ($startDateTimeElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $startDateTimeElement */
        $startDateTimeElement = $startDateTimeElements->item(0);

        $dateTimeStringElements = $xpath->query('.//udt:DateTimeString', $startDateTimeElement);

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
