<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\CrossIndustryInvoice\DataType\AllowanceIndicator;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

/**
 * BT-147-00.
 */
class AppliedTradeAllowanceCharge
{
    /**
     * BT-147-01.
     */
    private AllowanceIndicator $chargeIndicator;

    /**
     * BT-147.
     */
    private UnitPriceAmount $actualAmount;

    public function __construct(float $actualAmount)
    {
        $this->chargeIndicator = new AllowanceIndicator();
        $this->actualAmount    = new UnitPriceAmount($actualAmount);
    }

    public function getChargeIndicator(): AllowanceIndicator
    {
        return $this->chargeIndicator;
    }

    public function getActualAmount(): float
    {
        return $this->actualAmount->getValueRounded();
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:AppliedTradeAllowanceCharge');

        $element->appendChild($this->chargeIndicator->toXML($document));
        $element->appendChild($document->createElement('ram:ActualAmount', (string) $this->actualAmount->getValueRounded()));

        return $element;
    }
}
