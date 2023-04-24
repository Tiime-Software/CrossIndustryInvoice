<?php

namespace Tests\Tiime\CrossIndustryInvoice;

use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\EN16931\HeaderApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;
use Tiime\CrossIndustryInvoice\DataType\GuidelineSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\EN16931\BilledQuantity;
use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty;
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\EN16931\IncludedSupplyChainTradeLineItem;
use Tiime\CrossIndustryInvoice\EN16931\NetPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeAgreement;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeDelivery;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedTradeProduct;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\EN16931\SupplyChainTradeTransaction;
use Tiime\EN16931\DataType\CountryAlpha2Code;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\Identifier\InvoiceLineIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\InvoiceTypeCode;
use Tiime\EN16931\DataType\UnitOfMeasurement;
use Tiime\EN16931\DataType\VatCategory;

class CIIEN16931Test extends TestCase
{
    /**
     * @test
     * @testdox Create EN-16931 profile with mandatory fields
     */
    public function createEN16931ProfileWithMandatoryFields(): void
    {
        $invoice = new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::EN16931)
                )
            ),
            new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('InvoiceLineIdentifier')
                        ),
                        new SpecifiedTradeProduct('SpecifiedTradProduct'),
                        new SpecifiedLineTradeAgreement(
                            new NetPriceProductTradePrice(100)
                        ),
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(1, UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                        ),
                        new SpecifiedLineTradeSettlement(
                            new ApplicableTradeTax(VatCategory::STANDARD),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        )
                    )
                ],
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE)),
                    new BuyerTradeParty('BuyerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    [
                        new HeaderApplicableTradeTax(100, 100, VatCategory::STANDARD)
                    ],
                    new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40)
                )
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }
}