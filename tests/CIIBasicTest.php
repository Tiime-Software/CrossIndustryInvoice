<?php

namespace Tiime\CrossIndustryInvoice\Tests;

use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\Basic\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\DataType\ActualDeliverySupplyChainEvent;
use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;
use Tiime\CrossIndustryInvoice\DataType\Basic\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\Basic\BilledQuantity;
use Tiime\CrossIndustryInvoice\DataType\Basic\IncludedSupplyChainTradeLineItem;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeProduct;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\Basic\SupplyChainTradeTransaction;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\BuyerTradeParty;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\HeaderApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerTradeParty;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\BusinessProcessSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\DespatchAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\DocumentIncludedNote;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;
use Tiime\CrossIndustryInvoice\DataType\GuidelineSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\LocationGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\NetPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\DataType\OccurrenceDateTime;
use Tiime\CrossIndustryInvoice\DataType\SellerGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\ShipToTradeParty;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationVA;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\EN16931\DataType\CountryAlpha2Code;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\ElectronicAddressScheme;
use Tiime\EN16931\DataType\Identifier\ElectronicAddressIdentifier;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\Identifier\InvoiceLineIdentifier;
use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\LocationIdentifier;
use Tiime\EN16931\DataType\Identifier\SellerIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;
use Tiime\EN16931\DataType\InvoiceNoteCode;
use Tiime\EN16931\DataType\InvoiceTypeCode;
use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;
use Tiime\EN16931\DataType\UnitOfMeasurement;
use Tiime\EN16931\DataType\VatCategory;

class CIIBasicTest extends TestCase
{
    /**
     * @testdox Create Basic profile with mandatory fields
     */
    public function testCreateBasicProfileWithMandatoryFields(): void
    {
        $invoice = new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::BASICWL)
                )
            ),
            new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE)),
                    new BuyerTradeParty('BuyerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(50, 50, 50, 0),
                    [
                        new HeaderApplicableTradeTax(14.50, 50, VatCategory::STANDARD),
                    ],
                ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(new InvoiceLineIdentifier('FA-0001')),
                        new SpecifiedTradeProduct('Product 1'),
                        new SpecifiedLineTradeAgreement(new NetPriceProductTradePrice(100)),
                        new SpecifiedLineTradeDelivery(new BilledQuantity(1, UnitOfMeasurement::BALL_REC21)),
                        new SpecifiedLineTradeSettlement(
                            new ApplicableTradeTax(VatCategory::STANDARD),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        )
                    ),
                ],
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }

    /**
     * @testdox Create BasicWL profile with mandatory fields but empty array for (ApplicableHeaderTradeSettlement) $applicableTradeTaxes
     */
    public function testCreateBasicWLProfileWithMandatoryFieldsButEmptyArrayApplicableTradeTaxes(): void
    {
        $this->expectException(\Exception::class);

        new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::BASICWL)
                )
            ),
            new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE)),
                    new BuyerTradeParty('BuyerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(50, 50, 50, 0),
                    [],
                ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(new InvoiceLineIdentifier('FA-0001')),
                        new SpecifiedTradeProduct('Product 1'),
                        new SpecifiedLineTradeAgreement(new NetPriceProductTradePrice(100)),
                        new SpecifiedLineTradeDelivery(new BilledQuantity(1, UnitOfMeasurement::BALL_REC21)),
                        new SpecifiedLineTradeSettlement(
                            new ApplicableTradeTax(VatCategory::STANDARD),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        )
                    ),
                ],
            )
        );
    }

    /**
     * @testdox Create BasicWL profile with mandatory and optional fields
     */
    public function testCreateBasicWLProfileWithMandatoryAndOptionalFields(): void
    {
        $invoice = new CrossIndustryInvoice(
            (new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::BASICWL)
                )
            ))->setBusinessProcessSpecifiedDocumentContextParameter(new BusinessProcessSpecifiedDocumentContextParameter('BusinessProcess1')),
            (new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ))->setIncludedNotes(
                [
                    (new DocumentIncludedNote('DocumentIncludedNote1'))->setSubjectCode(InvoiceNoteCode::ADDITIONAL_CONDITIONS),
                ]
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    (new SellerTradeParty(
                        'SellerTradePartyName',
                        (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                            ->setPostcodeCode('PostcodeCode')
                            ->setLineOne('LineOne')
                            ->setLineTwo('LineTwo')
                            ->setLineThree('Line3')
                            ->setCityName('CityName')
                            ->setCountrySubDivisionName('CountrySubDivisionName')
                    ))
                        ->setIdentifiers([new SellerIdentifier('SellerIdentifier')])
                        ->setGlobalIdentifiers([new SellerGlobalIdentifier('SellerGlobalIdentifier', InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN)])
                        ->setSpecifiedTaxRegistrationVA(new SpecifiedTaxRegistrationVA(new VatIdentifier('FRSellerVatIdentifier')))
                        ->setSpecifiedLegalOrganization(
                            (new SellerSpecifiedLegalOrganization())
                                ->setTradingBusinessName('SellerTradingBusinessName')
                                ->setIdentifier(new LegalRegistrationIdentifier('SellerLegalRegistrationIdentifier'))
                        )
                        ->setURIUniversalCommunication(
                            new URIUniversalCommunication(
                                new ElectronicAddressIdentifier('ElectronicAddressIdentifier', ElectronicAddressScheme::FRENCH_VAT_NUMBER)
                            )
                        ),
                    new BuyerTradeParty('BuyerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                ),
                (new ApplicableHeaderTradeDelivery())
                    ->setShipToTradeParty(
                        (new ShipToTradeParty())
                            ->setIdentifier(new LocationIdentifier('LocationIdentifer'))
                            ->setName('ShipToTradeName')
                            ->setGlobalIdentifier(
                                new LocationGlobalIdentifier('LocationGlobalIdentifier', InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN)
                            )
                            ->setPostalTradeAddress(
                                (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                                    ->setPostcodeCode('PostcodeCode')
                                    ->setLineOne('LineOne')
                                    ->setLineTwo('LineTwo')
                                    ->setLineThree('Line3')
                                    ->setCityName('CityName')
                                    ->setCountrySubDivisionName('CountrySubDivisionName')
                            )
                    )
                    ->setActualDeliverySupplyChainEvent(
                        new ActualDeliverySupplyChainEvent(new OccurrenceDateTime(new \DateTime()))
                    )
                    ->setDespatchAdviceReferencedDocument(
                        new DespatchAdviceReferencedDocument(new DespatchAdviceReference('DespatchAdviceReference'))
                    ),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(50, 50, 50, 0),
                    [
                        new HeaderApplicableTradeTax(14.50, 50, VatCategory::STANDARD),
                    ],
                ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(new InvoiceLineIdentifier('FA-0001')),
                        new SpecifiedTradeProduct('Product 1'),
                        new SpecifiedLineTradeAgreement(new NetPriceProductTradePrice(100)),
                        new SpecifiedLineTradeDelivery(new BilledQuantity(1, UnitOfMeasurement::BALL_REC21)),
                        new SpecifiedLineTradeSettlement(
                            new ApplicableTradeTax(VatCategory::STANDARD),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        )
                    ),
                ],
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }

    /**
     * @testdox Create BasicWL profile from XML mandatory data
     */
    public function testCreateBasicWLProfileFromXMLMandatoryData(): void
    {
        $invoiceToConvert = new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::BASICWL)
                )
            ),
            new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE)),
                    new BuyerTradeParty('BuyerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(50, 50, 50, 0),
                    [
                        new HeaderApplicableTradeTax(14.50, 50, VatCategory::STANDARD),
                    ],
                ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(new InvoiceLineIdentifier('FA-0001')),
                        new SpecifiedTradeProduct('Product 1'),
                        new SpecifiedLineTradeAgreement(new NetPriceProductTradePrice(100)),
                        new SpecifiedLineTradeDelivery(new BilledQuantity(1, UnitOfMeasurement::BALL_REC21)),
                        new SpecifiedLineTradeSettlement(
                            new ApplicableTradeTax(VatCategory::STANDARD),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        )
                    ),
                ],
            )
        );

        $xmlInvoice = $invoiceToConvert->toXML();

        $document = new \DOMDocument();
        $document->loadXML($xmlInvoice->saveXML());

        $invoice = CrossIndustryInvoice::fromXML($document);
        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);
    }

    /**
     * @testdox Create BasicWL profile from XML mandatory and optional data
     */
    public function testCreateBasicWLProfileFromXMLMandatoryAndOptionalData(): void
    {
        $this->markTestSkipped('@todo');
    }
}
