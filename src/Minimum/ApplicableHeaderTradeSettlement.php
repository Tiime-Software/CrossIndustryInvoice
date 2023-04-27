<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\CrossIndustryInvoice\DataType\Minimum\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\EN16931\DataType\CurrencyCode;

/**
 * BG-19.
 */
class ApplicableHeaderTradeSettlement
{
    /**
     * BT-5.
     */
    private CurrencyCode $invoiceCurrencyCode;

    /**
     * BG-22.
     */
    private SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation;

    public function __construct(
        CurrencyCode $invoiceCurrencyCode,
        SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation
    ) {
        $this->invoiceCurrencyCode                             = $invoiceCurrencyCode;
        $this->specifiedTradeSettlementHeaderMonetarySummation = $specifiedTradeSettlementHeaderMonetarySummation;
    }

    public function getInvoiceCurrencyCode(): CurrencyCode
    {
        return $this->invoiceCurrencyCode;
    }

    public function getSpecifiedTradeSettlementHeaderMonetarySummation(): SpecifiedTradeSettlementHeaderMonetarySummation
    {
        return $this->specifiedTradeSettlementHeaderMonetarySummation;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ApplicableHeaderTradeSettlement');

        $element->appendChild($document->createElement('ram:InvoiceCurrencyCode', $this->invoiceCurrencyCode->value));
        $element->appendChild($this->specifiedTradeSettlementHeaderMonetarySummation->toXML($document));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $applicableHeaderTradeSettlementElements = $xpath->query('//ram:ApplicableHeaderTradeSettlement', $currentElement);

        if (1 !== $applicableHeaderTradeSettlementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeSettlementElement */
        $applicableHeaderTradeSettlementElement = $applicableHeaderTradeSettlementElements->item(0);

        $invoiceCurrencyCodeElements = $xpath->query('//ram:InvoiceCurrencyCode', $applicableHeaderTradeSettlementElement);

        if (1 !== $invoiceCurrencyCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        $invoiceCurrencyCode = CurrencyCode::tryFrom($invoiceCurrencyCodeElements->item(0)->nodeValue);

        if (null === $invoiceCurrencyCode) {
            throw new \Exception('Wrong currency code');
        }

        $specifiedTradeSettlementHeaderMonetarySummation = SpecifiedTradeSettlementHeaderMonetarySummation::fromXML($xpath, $applicableHeaderTradeSettlementElement);

        return new static($invoiceCurrencyCode, $specifiedTradeSettlementHeaderMonetarySummation);
    }
}
