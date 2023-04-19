<?php

namespace Tiime\CrossIndustryInvoice;
require_once('./vendor/autoload.php');

use Tiime\CrossIndustryInvoice\DataType\BuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;
use Tiime\CrossIndustryInvoice\DataType\GuidelineSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\Minimum\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\Minimum\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\Minimum\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\Minimum\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\Minimum\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\Minimum\BuyerTradeParty;
use Tiime\CrossIndustryInvoice\Minimum\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\Minimum\SellerTradeParty;
use Tiime\CrossIndustryInvoice\Minimum\SupplyChainTradeTransaction;
use Tiime\EN16931\DataType\CountryAlpha2Code;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\InvoiceTypeCode;
use Tiime\EN16931\DataType\Reference\PurchaseOrderReference;


$xml = (new CrossIndustryInvoice(
    new ExchangedDocumentContext(
        new GuidelineSpecifiedDocumentContextParameter(
            new SpecificationIdentifier(SpecificationIdentifier::MINIMUM)
        )
    ),
    new ExchangedDocument(
        new InvoiceIdentifier('FA-1545'),
        InvoiceTypeCode::COMMERCIAL_INVOICE,
        new IssueDateTime(new \DateTime())
    ),
    new SupplyChainTradeTransaction(
        new ApplicableHeaderTradeAgreement(
            new SellerTradeParty('TotoVendeur', new PostalTradeAddress(CountryAlpha2Code::AFGHANISTAN)),
            new BuyerTradeParty('MireilleAcheteuse'),
            new BuyerOrderReferencedDocument(new PurchaseOrderReference('A380'))
        ),
        new ApplicableHeaderTradeSettlement(
            CurrencyCode::ARUBAN_FLORIN,
            new SpecifiedTradeSettlementHeaderMonetarySummation(12, 13, 14)
        )
    )
))->toXML();
var_dump($xml->saveHTML());