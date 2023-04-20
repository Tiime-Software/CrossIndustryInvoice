<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-72-00.
 */
class ActualDeliverySupplyChainEvent
{
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
        $element = $document->createElement('ram:ActualDeliverySupplyChainEvent');

        $element->appendChild($this->occurrenceDateTime->toXML($document));

        return $element;
    }
}
