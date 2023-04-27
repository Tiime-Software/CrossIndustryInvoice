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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $taxTotalAmountElements = $xpath->query('//ram:TaxTotalAmount', $currentElement);

        if (0 === $taxTotalAmountElements->count()) {
            return null;
        }

        if ($taxTotalAmountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $taxTotalAmountElement */
        $taxTotalAmountElement = $taxTotalAmountElements->item(0);

        $valueElements = $xpath->query('//ram:TaxTotalAmount', $taxTotalAmountElement);

        if (1 !== $valueElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $valueItem */
        $valueItem = $valueElements->item(0);
        $value     = $valueItem->nodeValue;

        $currencyIdentifier = CurrencyCode::tryFrom($valueItem->getAttribute('currencyID'));

        if (null === $currencyIdentifier) {
            throw new \Exception('Wrong currencyID');
        }

        return new static((float) $value, $currencyIdentifier);
    }
}
