<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-74-00.
 */
class EndDateTime
{
    protected const string XML_NODE = 'ram:EndDateTime';

    /**
     * BT-74-0.
     */
    private string $format;

    /**
     * @param \DateTimeInterface $dateTimeString - BT-74
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
        $currentNode = $document->createElement(self::XML_NODE);

        $dateTimeElement = $document->createElement('udt:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', $this->format);

        $currentNode->appendChild($dateTimeElement);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $endDateTimeElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $endDateTimeElements->count()) {
            return null;
        }

        if ($endDateTimeElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $endDateTimeElement */
        $endDateTimeElement = $endDateTimeElements->item(0);

        $dateTimeStringElements = $xpath->query('./udt:DateTimeString', $endDateTimeElement);

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
