<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\AppliedTradeAllowanceCharge;

/**
 * BT-147-01.
 */
class ChargeIndicator
{
    /**
     * BT-147-02.
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

        $element->appendChild($document->createElement('udt:Indicator', $this->indicator ? 'true' : 'false'));

        return $element;
    }
}
