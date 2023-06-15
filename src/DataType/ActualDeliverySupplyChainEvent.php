<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-72-00.
 */
class ActualDeliverySupplyChainEvent
{
    protected const XML_NODE = 'ram:ActualDeliverySupplyChainEvent';

    /**
     * BT-72-01.
     */
    private OccurrenceDateTime $occurrenceDateTime;

    public function __construct(OccurrenceDateTime $occurrenceDateTime)
    {
        $this->occurrenceDateTime = $occurrenceDateTime;
    }

    public function getOccurrenceDateTime(): OccurrenceDateTime
    {
        return $this->occurrenceDateTime;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($this->occurrenceDateTime->toXML($document));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $actualDeliverySupplyChainEventElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $actualDeliverySupplyChainEventElements->count()) {
            return null;
        }

        if ($actualDeliverySupplyChainEventElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $actualDeliverySupplyChainEventElement */
        $actualDeliverySupplyChainEventElement = $actualDeliverySupplyChainEventElements->item(0);

        $occurrenceDateTime = OccurrenceDateTime::fromXML($xpath, $actualDeliverySupplyChainEventElement);

        return new self($occurrenceDateTime);
    }
}
