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
}
