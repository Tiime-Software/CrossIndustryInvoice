<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;

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
}
