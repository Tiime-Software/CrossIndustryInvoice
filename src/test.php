<?php

namespace Tiime\CrossIndustryInvoice;

require_once './vendor/autoload.php';

use Tiime\CrossIndustryInvoice\DataType\BusinessProcessSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\BuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;
use Tiime\CrossIndustryInvoice\DataType\GuidelineSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\Minimum\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\Minimum\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\Minimum\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\Minimum\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\CrossIndustryInvoice\Minimum\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\Minimum\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\Minimum\BuyerTradeParty;
use Tiime\CrossIndustryInvoice\Minimum\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\Minimum\SellerTradeParty;
use Tiime\CrossIndustryInvoice\Minimum\SpecifiedTaxRegistration;
use Tiime\CrossIndustryInvoice\Minimum\SupplyChainTradeTransaction;
use Tiime\EN16931\DataType\CountryAlpha2Code;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;
use Tiime\EN16931\DataType\InvoiceTypeCode;
use Tiime\EN16931\DataType\Reference\PurchaseOrderReference;

/**
 * Minimum profile with mandatory items.
 */
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
var_dump($xml->saveXML());

/**
 * Minimum profile with optional and mandatory items.
 */

/** ExchangedDocumentContext part */
$exchangedDocumentContext = new ExchangedDocumentContext(
    new GuidelineSpecifiedDocumentContextParameter(
        new SpecificationIdentifier(SpecificationIdentifier::MINIMUM)
    )
);
$businessProcessSpecifiedDocumentContextParameter = new BusinessProcessSpecifiedDocumentContextParameter('BusinessProcess1');
$exchangedDocumentContext->setBusinessProcessSpecifiedDocumentContextParameter($businessProcessSpecifiedDocumentContextParameter);

/** BuyerTradeParty part */
$buyerTradeParty                 = new BuyerTradeParty('MireilleAcheteuse');
$buyerSpecifiedLegalOrganization = new BuyerSpecifiedLegalOrganization(
    new LegalRegistrationIdentifier('LegalRegistrationBuyer', InternationalCodeDesignator::ADVANTIS)
);
$buyerTradeParty->setSpecifiedLegalOrganization($buyerSpecifiedLegalOrganization);

/** SellerTradeParty part */
$sellerTradeParty                 = new SellerTradeParty('TotoVendeur', new PostalTradeAddress(CountryAlpha2Code::AFGHANISTAN));
$sellerSpecifiedLegalOrganization = new SellerSpecifiedLegalOrganization();
$legalRegistrationIdentifier      = new LegalRegistrationIdentifier('LegalRegistrationSeller', InternationalCodeDesignator::ALCANET_ALCATEL_ALSTHOM_CORPORATE_NETWORK);
$sellerSpecifiedLegalOrganization->setIdentifier($legalRegistrationIdentifier);
$taxId1 = new SpecifiedTaxRegistration(new VatIdentifier('FRVatId1'));
$taxId2 = new SpecifiedTaxRegistration(new VatIdentifier('FRVatId2'));
$sellerTradeParty->setSpecifiedTaxRegistrations([$taxId1, $taxId2]);

/** SpecifiedTradeSettlementHeaderMonetarySummation part */
$specifiedTradeSettlementHeaderMonetarySummation = new SpecifiedTradeSettlementHeaderMonetarySummation(
    12,
    13,
    14,
    new TaxTotalAmount('24', CurrencyCode::BELIZE_DOLLAR)
);

$xml = (new CrossIndustryInvoice(
    $exchangedDocumentContext,
    new ExchangedDocument(
        new InvoiceIdentifier('FA-1545'),
        InvoiceTypeCode::COMMERCIAL_INVOICE,
        new IssueDateTime(new \DateTime())
    ),
    new SupplyChainTradeTransaction(
        new ApplicableHeaderTradeAgreement(
            $sellerTradeParty,
            $buyerTradeParty,
            new BuyerOrderReferencedDocument(new PurchaseOrderReference('A380'))
        ),
        new ApplicableHeaderTradeSettlement(
            CurrencyCode::ARUBAN_FLORIN,
            $specifiedTradeSettlementHeaderMonetarySummation
        )
    )
))->toXML();
var_dump($xml->saveXML());
