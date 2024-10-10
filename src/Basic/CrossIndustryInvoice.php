<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\BasicWL\CrossIndustryInvoice as BasicWLCrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\CrossIndustryInvoiceInterface;
use Tiime\CrossIndustryInvoice\DataType\Basic\SupplyChainTradeTransaction;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;

class CrossIndustryInvoice extends BasicWLCrossIndustryInvoice implements CrossIndustryInvoiceInterface
{
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
            throw new \LogicException('Must be of type Basic\\SupplyChainTradeTransaction');
        }

        return $supplyChainTradeTransaction;
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
