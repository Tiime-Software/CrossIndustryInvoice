<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BG-20-0.
 */
class AllowanceIndicator
{
    /**
     * BG-20-1.
     */
    private bool $indicator;

    public function __construct()
    {
        $this->indicator = false;
    }

    public function getIndicator(): bool
    {
        return $this->indicator;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ChargeIndicator');

        $element->appendChild($document->createElement('udt:Indicator', 'false'));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        // todo
    }
}
