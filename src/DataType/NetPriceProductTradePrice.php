<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\Basic\BasisQuantity;
use Tiime\EN16931\BusinessTermsGroup\PriceDetails;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

/**
 * BT-146-00.
 */
class NetPriceProductTradePrice
{
    protected const XML_NODE = 'ram:NetPriceProductTradePrice';

    /**
     * BT-146.
     */
    private UnitPriceAmount $chargeAmount;

    /**
     * BT-149 & BT-150.
     */
    private ?BasisQuantity $basisQuantity;

    public function __construct(float $chargeAmount)
    {
        $this->chargeAmount  = new UnitPriceAmount($chargeAmount);
        $this->basisQuantity = null;
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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:ChargeAmount', $this->chargeAmount->getFormattedValueRounded()));

        if ($this->basisQuantity instanceof BasisQuantity) {
            $element->appendChild($this->basisQuantity->toXML($document));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $netPriceProductTradePriceElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $netPriceProductTradePriceElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $netPriceProductTradePriceElement */
        $netPriceProductTradePriceElement = $netPriceProductTradePriceElements->item(0);

        $chargeAmountElements = $xpath->query('./ram:ChargeAmount', $netPriceProductTradePriceElement);

        if (1 !== $chargeAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        $chargeAmount  = $chargeAmountElements->item(0)->nodeValue;
        $basisQuantity = BasisQuantity::fromXML($xpath, $netPriceProductTradePriceElement);

        $netPriceProductTradePrice = new self((float) $chargeAmount);

        if ($basisQuantity instanceof BasisQuantity) {
            $netPriceProductTradePrice->setBasisQuantity($basisQuantity);
        }

        return $netPriceProductTradePrice;
    }

    public static function fromEN16931(PriceDetails $priceDetails): self
    {
        $basisQuantity = \is_float($priceDetails->getItemPriceBaseQuantity()?->getValueRounded())
            ? BasisQuantity::fromEN16931($priceDetails)
            : null;

        return (new self($priceDetails->getItemNetPrice()?->getValueRounded()))
            ->setBasisQuantity($basisQuantity);
    }
}
