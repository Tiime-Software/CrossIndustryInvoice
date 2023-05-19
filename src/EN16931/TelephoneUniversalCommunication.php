<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BT-42-00.
 */
class TelephoneUniversalCommunication
{
    protected const XML_NODE = 'ram:TelephoneUniversalCommunication';

    /**
     * BT-42 or BT-57.
     */
    private string $completeNumber;

    public function __construct(string $completeNumber)
    {
        $this->completeNumber = $completeNumber;
    }

    public function getCompleteNumber(): string
    {
        return $this->completeNumber;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:CompleteNumber', $this->completeNumber));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $telephoneUniversalCommunicationElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $telephoneUniversalCommunicationElements->count()) {
            return null;
        }

        if ($telephoneUniversalCommunicationElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $telephoneUniversalCommunicationElement */
        $telephoneUniversalCommunicationElement = $telephoneUniversalCommunicationElements->item(0);

        $completeNumberElements = $xpath->query('.//ram:CompleteNumber', $telephoneUniversalCommunicationElement);

        if (1 !== $completeNumberElements->count()) {
            throw new \Exception('Malformed');
        }

        $completeNumber = $completeNumberElements->item(0)->nodeValue;

        return new self($completeNumber);
    }
}
