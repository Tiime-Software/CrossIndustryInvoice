<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;
use Tiime\CrossIndustryInvoice\DataType\Minimum\ExchangedDocument;

class CrossIndustryInvoice
{
    /**
     * BG-2.
     */
    private ExchangedDocumentContext $exchangedDocumentContext;

    /**
     * BT-1-00.
     */
    private ExchangedDocument $exchangedDocument;

    /**
     * BG-25-00.
     */
    private SupplyChainTradeTransaction $supplyChainTradeTransaction;

    public function __construct(
        ExchangedDocumentContext $exchangedDocumentContext,
        ExchangedDocument $exchangedDocument,
        SupplyChainTradeTransaction $supplyChainTradeTransaction
    ) {
        $this->exchangedDocumentContext    = $exchangedDocumentContext;
        $this->exchangedDocument           = $exchangedDocument;
        $this->supplyChainTradeTransaction = $supplyChainTradeTransaction;
    }

    public function getExchangedDocumentContext(): ExchangedDocumentContext
    {
        return $this->exchangedDocumentContext;
    }

    public function getExchangedDocument(): ExchangedDocument
    {
        return $this->exchangedDocument;
    }

    public function getSupplyChainTradeTransaction(): SupplyChainTradeTransaction
    {
        return $this->supplyChainTradeTransaction;
    }

    public function toXML(): \DOMDocument
    {
        $document = new \DOMDocument('1.0', 'UTF-8');

        $crossIndustryInvoice = $document->createElement('rsm:CrossIndustryInvoice');
        $crossIndustryInvoice->setAttribute(
            'xmlns:qdt',
            'urn:un:unece:uncefact:data:standard:QualifiedDataType:100'
        );
        $crossIndustryInvoice->setAttribute(
            'xmlns:ram',
            'urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100'
        );
        $crossIndustryInvoice->setAttribute(
            'xmlns:rsm',
            'urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100'
        );
        $crossIndustryInvoice->setAttribute(
            'xmlns:udt',
            'urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100'
        );
        $crossIndustryInvoice->setAttribute(
            'xmlns:xsi',
            'http://www.w3.org/2001/XMLSchema-instance'
        );

        $root = $document->appendChild($crossIndustryInvoice);

        $root->appendChild($this->exchangedDocumentContext->toXML($document));
        $root->appendChild($this->exchangedDocument->toXML($document));
        $root->appendChild($this->supplyChainTradeTransaction->toXML($document));

        return $document;
    }

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $crossIndustryInvoiceElements = $xpath->query('//rsm:CrossIndustryInvoice');

        if (1 !== $crossIndustryInvoiceElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $crossIndustryInvoiceElement */
        $crossIndustryInvoiceElement = $crossIndustryInvoiceElements->item(0);

        $exchangedDocumentContext    = ExchangedDocumentContext::fromXML($xpath, $crossIndustryInvoiceElement);
        $exchangedDocument           = ExchangedDocument::fromXML($xpath, $crossIndustryInvoiceElement);
        $supplyChainTradeTransaction = SupplyChainTradeTransaction::fromXML($xpath, $crossIndustryInvoiceElement);

        return new static($exchangedDocumentContext, $exchangedDocument, $supplyChainTradeTransaction);
    }
}
