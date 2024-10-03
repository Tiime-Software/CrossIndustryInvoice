<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BG-20-0.
 */
class AllowanceIndicator
{
    protected const XML_NODE = 'ram:ChargeIndicator';

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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('udt:Indicator', 'false'));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $allowanceIndicatorElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $allowanceIndicatorElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $allowanceIndicatorElement */
        $allowanceIndicatorElement = $allowanceIndicatorElements->item(0);

        $indicatorElements = $xpath->query('./udt:Indicator', $allowanceIndicatorElement);

        if (1 !== $indicatorElements->count()) {
            throw new \Exception('Malformed');
        }

        $indicator = $indicatorElements->item(0)->nodeValue;

        if (mb_strtolower('false') !== mb_strtolower($indicator)) {
            throw new \Exception('Malformed');
        }

        return new self();
    }
}
