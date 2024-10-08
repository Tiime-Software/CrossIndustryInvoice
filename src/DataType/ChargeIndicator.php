<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BG-21-0.
 */
class ChargeIndicator
{
    protected const string XML_NODE = 'ram:ChargeIndicator';

    /**
     * BG-21-1.
     */
    private bool $indicator;

    public function __construct()
    {
        $this->indicator = true;
    }

    public function getIndicator(): bool
    {
        return $this->indicator;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ChargeIndicator');

        $element->appendChild($document->createElement('udt:Indicator', 'true'));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $chargeIndicatorElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $chargeIndicatorElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $chargeIndicatorElement */
        $chargeIndicatorElement = $chargeIndicatorElements->item(0);

        $indicatorElements = $xpath->query('./udt:Indicator', $chargeIndicatorElement);

        if (1 !== $indicatorElements->count()) {
            throw new \Exception('Malformed');
        }

        $indicator = $indicatorElements->item(0)->nodeValue;

        if (mb_strtolower('true') !== mb_strtolower($indicator)) {
            throw new \Exception('Malformed');
        }

        return new self();
    }
}
