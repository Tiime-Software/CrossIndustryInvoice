<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\Codelist\CurrencyCodeISO4217;
use Tiime\EN16931\SemanticDataType\Amount;

class TaxTotalAmount
{
    protected const string XML_NODE = 'ram:TaxTotalAmount';

    /**
     * BT-110.
     */
    private Amount $value;

    /**
     * @param CurrencyCodeISO4217 $currencyIdentifier - BT-110-0
     */
    public function __construct(float $value, private CurrencyCodeISO4217 $currencyIdentifier)
    {
        $this->value = new Amount($value);
    }

    public function getValue(): Amount
    {
        return $this->value;
    }

    public function getCurrencyIdentifier(): CurrencyCodeISO4217
    {
        return $this->currencyIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE, $this->value->getFormattedValueRounded());

        $element->setAttribute('currencyID', $this->currencyIdentifier->value);

        return $element;
    }

    /** Doesn't take DOMXPath as an argument like other classes to fit the use of this method for Minumum and BasicWL profiles */
    public static function fromXML(\DOMElement $currentElement): self
    {
        $value              = $currentElement->nodeValue;
        $currencyIdentifier = '' !== $currentElement->getAttribute('currencyID') ?
            CurrencyCodeISO4217::tryFrom($currentElement->getAttribute('currencyID')) : null;

        if (null === $currencyIdentifier) {
            throw new \Exception('Wrong currencyID');
        }

        return new self((float) $value, $currencyIdentifier);
    }
}
