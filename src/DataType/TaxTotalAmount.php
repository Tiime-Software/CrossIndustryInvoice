<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\SemanticDataType\Amount;

class TaxTotalAmount
{
    protected const XML_NODE = 'ram:TaxTotalAmount';

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
        $element = $document->createElement(self::XML_NODE, (string) $this->value->getValueRounded());

        $element->setAttribute('currencyID', $this->currencyIdentifier->value);

        return $element;
    }

    /** Doesn't take DOMXPath as an argument like other classes to fit the use of this method for Minumum and BasicWL profiles */
    public static function fromXML(\DOMElement $currentElement): static
    {
        $value              = $currentElement->nodeValue;
        $currencyIdentifier = '' !== $currentElement->getAttribute('currencyID') ?
            CurrencyCode::tryFrom($currentElement->getAttribute('currencyID')) : null;

        if (null === $currencyIdentifier) {
            throw new \Exception('Wrong currencyID');
        }

        return new static((float) $value, $currencyIdentifier);
    }
}
