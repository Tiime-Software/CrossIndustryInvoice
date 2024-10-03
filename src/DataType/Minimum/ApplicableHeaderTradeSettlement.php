<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\EN16931\DataType\CurrencyCode;

/**
 * BG-19.
 */
class ApplicableHeaderTradeSettlement
{
    protected const XML_NODE = 'ram:ApplicableHeaderTradeSettlement';

    /**
     * @param CurrencyCode                                    $invoiceCurrencyCode                             - BT-5
     * @param SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation - BG-22
     */
    public function __construct(
        protected CurrencyCode $invoiceCurrencyCode,
        protected SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation,
    ) {
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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:InvoiceCurrencyCode', $this->invoiceCurrencyCode->value));
        $currentNode->appendChild($this->specifiedTradeSettlementHeaderMonetarySummation->toXML($document));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $applicableHeaderTradeSettlementElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeSettlementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeSettlementElement */
        $applicableHeaderTradeSettlementElement = $applicableHeaderTradeSettlementElements->item(0);

        $invoiceCurrencyCodeElements = $xpath->query('./ram:InvoiceCurrencyCode', $applicableHeaderTradeSettlementElement);

        if (1 !== $invoiceCurrencyCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        $invoiceCurrencyCode = CurrencyCode::tryFrom($invoiceCurrencyCodeElements->item(0)->nodeValue);

        if (null === $invoiceCurrencyCode) {
            throw new \Exception('Wrong currency code');
        }

        $specifiedTradeSettlementHeaderMonetarySummation = SpecifiedTradeSettlementHeaderMonetarySummation::fromXML($xpath, $applicableHeaderTradeSettlementElement);

        return new self($invoiceCurrencyCode, $specifiedTradeSettlementHeaderMonetarySummation);
    }
}
