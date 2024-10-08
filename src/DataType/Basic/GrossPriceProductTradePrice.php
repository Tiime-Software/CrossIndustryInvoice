<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\EN16931\BusinessTermsGroup\PriceDetails;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

/**
 * BT-148-00.
 */
class GrossPriceProductTradePrice
{
    protected const string XML_NODE = 'ram:GrossPriceProductTradePrice';

    /**
     * BT-148.
     */
    private UnitPriceAmount $chargeAmount;

    /**
     * BT-149-1 & BT-150-1.
     */
    private ?BasisQuantity $basisQuantity;

    /**
     * BT-147-00.
     */
    private ?AppliedTradeAllowanceCharge $appliedTradeAllowanceCharge;

    public function __construct(float $chargeAmount)
    {
        $this->chargeAmount                = new UnitPriceAmount($chargeAmount);
        $this->basisQuantity               = null;
        $this->appliedTradeAllowanceCharge = null;
    }

    public function getChargeAmount(): UnitPriceAmount
    {
        return $this->chargeAmount;
    }

    public function getBasisQuantity(): ?BasisQuantity
    {
        return $this->basisQuantity;
    }

    public function setBasisQuantity(?BasisQuantity $basisQuantity): static
    {
        $this->basisQuantity = $basisQuantity;

        return $this;
    }

    public function getAppliedTradeAllowanceCharge(): ?AppliedTradeAllowanceCharge
    {
        return $this->appliedTradeAllowanceCharge;
    }

    public function setAppliedTradeAllowanceCharge(?AppliedTradeAllowanceCharge $appliedTradeAllowanceCharge): static
    {
        $this->appliedTradeAllowanceCharge = $appliedTradeAllowanceCharge;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:ChargeAmount', $this->chargeAmount->getFormattedValueRounded()));

        if ($this->basisQuantity instanceof BasisQuantity) {
            $element->appendChild($this->basisQuantity->toXML($document));
        }

        if ($this->appliedTradeAllowanceCharge instanceof AppliedTradeAllowanceCharge) {
            $element->appendChild($this->appliedTradeAllowanceCharge->toXML($document));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $grossPriceProductTradePriceElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $grossPriceProductTradePriceElements->count()) {
            return null;
        }

        if ($grossPriceProductTradePriceElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $grossPriceProductTradePriceElement */
        $grossPriceProductTradePriceElement = $grossPriceProductTradePriceElements->item(0);

        $chargeAmountElements = $xpath->query('./ram:ChargeAmount', $grossPriceProductTradePriceElement);

        if (1 !== $chargeAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        $chargeAmount = $chargeAmountElements->item(0)->nodeValue;

        $basisQuantity               = BasisQuantity::fromXML($xpath, $grossPriceProductTradePriceElement);
        $appliedTradeAllowanceCharge = AppliedTradeAllowanceCharge::fromXML($xpath, $grossPriceProductTradePriceElement);

        $grossPriceProductTradePrice = new self((float) $chargeAmount);

        if ($basisQuantity instanceof BasisQuantity) {
            $grossPriceProductTradePrice->setBasisQuantity($basisQuantity);
        }

        if ($appliedTradeAllowanceCharge instanceof AppliedTradeAllowanceCharge) {
            $grossPriceProductTradePrice->setAppliedTradeAllowanceCharge($appliedTradeAllowanceCharge);
        }

        return $grossPriceProductTradePrice;
    }

    public static function fromEN16931(PriceDetails $priceDetails): self
    {
        $appliedTradeAllowanceCharge = \is_float($priceDetails->getItemPriceDiscount())
            ? AppliedTradeAllowanceCharge::fromEN16931($priceDetails)
            : null;

        return (new self($priceDetails->getItemGrossPrice()?->getValueRounded()))
            ->setBasisQuantity(BasisQuantity::fromEN16931($priceDetails))
            ->setAppliedTradeAllowanceCharge($appliedTradeAllowanceCharge);
    }
}
