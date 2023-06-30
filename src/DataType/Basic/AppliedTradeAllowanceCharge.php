<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\CrossIndustryInvoice\DataType\AllowanceIndicator;
use Tiime\EN16931\BusinessTermsGroup\PriceDetails;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

/**
 * BT-147-00.
 */
class AppliedTradeAllowanceCharge
{
    protected const XML_NODE = 'ram:AppliedTradeAllowanceCharge';

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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->chargeIndicator->toXML($document));
        $currentNode->appendChild($document->createElement('ram:ActualAmount', $this->actualAmount->getFormattedValueRounded()));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $appliedTradeAllowanceChargeElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $appliedTradeAllowanceChargeElements->count()) {
            return null;
        }

        if ($appliedTradeAllowanceChargeElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $appliedTradeAllowanceChargeElement */
        $appliedTradeAllowanceChargeElement = $appliedTradeAllowanceChargeElements->item(0);

        $actualAmountElements = $xpath->query('./ram:ActualAmount', $appliedTradeAllowanceChargeElement);

        if ($actualAmountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $actualAmount = $actualAmountElements->item(0)->nodeValue;

        // Look if node is well constructed, already created in the constructor
        AllowanceIndicator::fromXML($xpath, $appliedTradeAllowanceChargeElement);

        return new self((float) $actualAmount);
    }

    public static function fromEN16931(PriceDetails $priceDetails): self
    {
        return new self($priceDetails->getItemPriceDiscount());
    }
}
