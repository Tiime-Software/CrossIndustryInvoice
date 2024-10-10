<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\Basic\CrossIndustryInvoice as BasicCrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\CrossIndustryInvoiceInterface;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SupplyChainTradeTransaction;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;

class CrossIndustryInvoice extends BasicCrossIndustryInvoice implements CrossIndustryInvoiceInterface
{
    protected const string XML_NODE = 'rsm:CrossIndustryInvoice';

    /**
     * @param ExchangedDocumentContext    $exchangedDocumentContext    - BG-2
     * @param ExchangedDocument           $exchangedDocument           - BT-1-00
     * @param SupplyChainTradeTransaction $supplyChainTradeTransaction - BG-25-00
     */
    public function __construct(
        ExchangedDocumentContext $exchangedDocumentContext,
        ExchangedDocument $exchangedDocument,
        SupplyChainTradeTransaction $supplyChainTradeTransaction,
    ) {
        parent::__construct($exchangedDocumentContext, $exchangedDocument, $supplyChainTradeTransaction);
    }

    public function getSupplyChainTradeTransaction(): SupplyChainTradeTransaction
    {
        $supplyChainTradeTransaction = parent::getSupplyChainTradeTransaction();

        if (!$supplyChainTradeTransaction instanceof SupplyChainTradeTransaction) {
            throw new \LogicException('Must be of type EN16931\\SupplyChainTradeTransaction');
        }

        return $supplyChainTradeTransaction;
    }

    public function toXML(): \DOMDocument
    {
        $document = new \DOMDocument('1.0', 'UTF-8');

        $crossIndustryInvoice = $document->createElement(self::XML_NODE);
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

    public static function fromXML(\DOMDocument $document): self
    {
        $xpath = new \DOMXPath($document);

        $crossIndustryInvoiceElements = $xpath->query(\sprintf('//%s', self::XML_NODE));

        if (1 !== $crossIndustryInvoiceElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $crossIndustryInvoiceElement */
        $crossIndustryInvoiceElement = $crossIndustryInvoiceElements->item(0);

        $exchangedDocumentContext    = ExchangedDocumentContext::fromXML($xpath, $crossIndustryInvoiceElement);
        $exchangedDocument           = ExchangedDocument::fromXML($xpath, $crossIndustryInvoiceElement);
        $supplyChainTradeTransaction = SupplyChainTradeTransaction::fromXML($xpath, $crossIndustryInvoiceElement);

        return new self($exchangedDocumentContext, $exchangedDocument, $supplyChainTradeTransaction);
    }
}
