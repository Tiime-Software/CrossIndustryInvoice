<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-26-00.
 */
class FormattedIssueDateTime
{
    protected const XML_NODE = 'ram:FormattedIssueDateTime';

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
        $currentNode = $document->createElement(self::XML_NODE);

        $dateTimeElement = $document->createElement('qdt:DateTimeString', $this->dateTimeString->format('Ymd'));
        $dateTimeElement->setAttribute('format', $this->format);

        $currentNode->appendChild($dateTimeElement);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $formattedIssueDateTimelements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $formattedIssueDateTimelements->count()) {
            return null;
        }

        if ($formattedIssueDateTimelements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $formattedIssueDateTimelement */
        $formattedIssueDateTimelement = $formattedIssueDateTimelements->item(0);

        $dateTimeStringElements = $xpath->query('./qdt:DateTimeString', $formattedIssueDateTimelement);

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
