<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;

class CrossIndustryInvoice extends \Tiime\CrossIndustryInvoice\BasicWL\CrossIndustryInvoice
{
    public function __construct(
        ExchangedDocumentContext $exchangedDocumentContext,
        ExchangedDocument $exchangedDocument,
        SupplyChainTradeTransaction $supplyChainTradeTransaction
    ) {
        parent::__construct($exchangedDocumentContext, $exchangedDocument, $supplyChainTradeTransaction);
    }

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $crossIndustryInvoiceElements = $xpath->query(sprintf('//%s', self::XML_NODE));

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
