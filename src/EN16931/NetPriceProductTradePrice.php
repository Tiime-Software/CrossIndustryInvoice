<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\Basic\BasisQuantity;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

/**
 * BT-146-00.
 */
class NetPriceProductTradePrice
{
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
        $element = $document->createElement('ram:NetPriceProductTradePrice');

        $element->appendChild($document->createElement('ram:ChargeAmount', (string) $this->chargeAmount->getValueRounded()));

        if ($this->basisQuantity instanceof BasisQuantity) {
            $element->appendChild($this->basisQuantity->toXML($document));
        }

        return $element;
    }
}
