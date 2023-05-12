<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-7-00.
 */
class TaxPointDate
{
    protected const XML_NODE = 'ram:TaxPointDate';

    /**
     * BT-7.
     */
    private \DateTimeInterface $dateString;

    /**
     * BT-7-0.
     */
    private readonly string $format;

    public function __construct(\DateTimeInterface $dateString)
    {
        $this->dateString = $dateString;
        $this->format     = '102';
    }

    public function getDateString(): \DateTimeInterface
    {
        return $this->dateString;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $dateStringElement = $document->createElement('udt:DateString', $this->dateString->format('Ymd'));
        $dateStringElement->setAttribute('format', $this->format);
        $currentNode->appendChild($dateStringElement);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $taxPointDateElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $taxPointDateElements->count()) {
            return null;
        }

        if ($taxPointDateElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $taxPointDateElement */
        $taxPointDateElement = $taxPointDateElements->item(0);

        $dateStringElements = $xpath->query('.//udt:DateString', $taxPointDateElement);

        if (1 !== $dateStringElements->count()) {
            throw new \Exception('Malformed');
        }

        $dateStringItem = $dateStringElements->item(0);
        $dateString     = $dateStringItem->nodeValue;

        if ('102' !== $dateStringItem->getAttribute('format')) {
            throw new \Exception('Wrong format');
        }

        $formattedDateTime = \DateTime::createFromFormat('Ymd', $dateString);

        if (!$formattedDateTime) {
            throw new \Exception('Malformed date');
        }

        $formattedDateTime->setTime(0, 0);

        return new self($formattedDateTime);
    }
}
