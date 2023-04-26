<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\SemanticDataType\Amount;

class TaxTotalAmount
{
    /**
     * BT-110.
     */
    private Amount $value;

    /**
     * BT-110-0.
     */
    private CurrencyCode $currencyIdentifier;

    public function __construct(float $value, CurrencyCode $currencyIdentifier)
    {
        $this->value              = new Amount($value);
        $this->currencyIdentifier = $currencyIdentifier;
    }

    public function getValue(): float
    {
        return $this->value->getValueRounded();
    }

    public function getCurrencyIdentifier(): CurrencyCode
    {
        return $this->currencyIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:TaxTotalAmount', (string) $this->value->getValueRounded());
        $element->setAttribute('currencyID', $this->currencyIdentifier->value);

        return $element;
    }

    public static function fromXML(\DOMDocument $document): static
    {
    }

}
