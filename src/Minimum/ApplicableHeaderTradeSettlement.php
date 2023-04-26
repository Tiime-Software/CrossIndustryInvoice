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

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $invoiceCurrencyCodeElements                             = $xpath->query('//ram:InvoiceCurrencyCode');
        $specifiedTradeSettlementHeaderMonetarySummationElements = $xpath->query('//ram:SpecifiedTradeSettlementHeaderMonetarySummation');

        if (1 !== $invoiceCurrencyCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $specifiedTradeSettlementHeaderMonetarySummationElements->count()) {
            throw new \Exception('Malformed');
        }

        $invoiceCurrencyCode = CurrencyCode::tryFrom($invoiceCurrencyCodeElements->item(0)->nodeValue);

        if (null === $invoiceCurrencyCode) {
            throw new \Exception('Wrong currency code');
        }

        $specifiedTradeSettlementHeaderMonetarySummationDocument = new \DOMDocument();
        $specifiedTradeSettlementHeaderMonetarySummationDocument->appendChild($specifiedTradeSettlementHeaderMonetarySummationDocument->importNode($specifiedTradeSettlementHeaderMonetarySummationElements->item(0), true));
        $specifiedTradeSettlementHeaderMonetarySummation = SpecifiedTradeSettlementHeaderMonetarySummation::fromXML($specifiedTradeSettlementHeaderMonetarySummationDocument);

        return new static($invoiceCurrencyCode, $specifiedTradeSettlementHeaderMonetarySummation);
    }
}
