<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
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
use Tiime\CrossIndustryInvoice\Utils\CrossIndustryInvoiceUtils;
use Tiime\EN16931\Codelist\CountryAlpha2Code;
use Tiime\EN16931\Codelist\CurrencyCodeISO4217;
use Tiime\EN16931\Codelist\DutyTaxFeeCategoryCodeUNTDID5305;
use Tiime\EN16931\Codelist\ElectronicAddressSchemeCode;
use Tiime\EN16931\Codelist\InternationalCodeDesignator;
use Tiime\EN16931\Codelist\InvoiceTypeCodeUNTDID1001;
use Tiime\EN16931\Codelist\TextSubjectCodeUNTDID4451;
use Tiime\EN16931\Codelist\UnitOfMeasureCode;
use Tiime\EN16931\DataType\Identifier\ElectronicAddressIdentifier;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\Identifier\InvoiceLineIdentifier;
use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\LocationIdentifier;
use Tiime\EN16931\DataType\Identifier\SellerIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;
use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;

class CIIBasicTest extends TestCase
{
    public function testValidateXsdError(): void
    {
        $xml = "<?xml version='1.0' encoding='UTF-8'?>
            <rsm:CrossIndustryInvoice xmlns:qdt=\"urn:un:unece:uncefact:data:standard:QualifiedDataType:100\" xmlns:ram=\"urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100\" xmlns:rsm=\"urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100\" xmlns:udt=\"urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
              <rsm:ExchangedDocumentContext>
                <ram:GuidelineSpecifiedDocumentContextParameter>
                  <ram:ID>urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic</ram:ID>
                </ram:GuidelineSpecifiedDocumentContextParameter>
              </rsm:ExchangedDocumentContext>
              <rsm:ExchangedDocument>
                <ram:ID>FA-2017-0010</ram:ID>
                <ram:TypeCode>380</ram:TypeCode>
                <ram:IssueDateTime>
                  <udt:DateTimeString format=\"102\">20171113</udt:DateTimeString>
                </ram:IssueDateTime>
                <ram:IncludedNote>
                  <ram:Content>Franco de port (commande &gt; 300 € HT)</ram:Content>
                </ram:IncludedNote>
              </rsm:ExchangedDocument>
            </rsm:CrossIndustryInvoice>";

        $document = new \DOMDocument();
        $document->loadXML($xml);

        $xsdErrors = CrossIndustryInvoiceUtils::validateXSD($document, 'BASIC');

        $this->assertCount(1, $xsdErrors);
    }

    #[DataProvider('provideBasicXml')]
    public function testValidateXSDSuccess(string $filename): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/Fixtures/Basic/' . $filename . '.xml'));

        $xsdErrors = CrossIndustryInvoiceUtils::validateXSD($document, 'BASIC');

        $this->assertCount(0, $xsdErrors);
    }

    #[TestDox('Create Basic profile with mandatory fields')]
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
                InvoiceTypeCodeUNTDID1001::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE)),
                    new BuyerTradeParty('BuyerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCodeISO4217::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(50, 50, 50, 0),
                    [
                        new HeaderApplicableTradeTax(14.50, 50, DutyTaxFeeCategoryCodeUNTDID5305::STANDARD_RATE),
                    ],
                ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(new InvoiceLineIdentifier('FA-0001')),
                        new SpecifiedTradeProduct('Product 1'),
                        new SpecifiedLineTradeAgreement(new NetPriceProductTradePrice(100)),
                        new SpecifiedLineTradeDelivery(new BilledQuantity(1, UnitOfMeasureCode::BALL)),
                        new SpecifiedLineTradeSettlement(
                            new ApplicableTradeTax(DutyTaxFeeCategoryCodeUNTDID5305::STANDARD_RATE),
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

    #[TestDox('Create BasicWL profile with mandatory and optional fields')]
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
                InvoiceTypeCodeUNTDID1001::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ))->setIncludedNotes(
                [
                    (new DocumentIncludedNote('DocumentIncludedNote1'))->setSubjectCode(TextSubjectCodeUNTDID4451::ADDITIONAL_CONDITIONS),
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
                                new ElectronicAddressIdentifier('ElectronicAddressIdentifier', ElectronicAddressSchemeCode::FRENCH_VAT_NUMBER)
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
                    CurrencyCodeISO4217::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(50, 50, 50, 0),
                    [
                        new HeaderApplicableTradeTax(14.50, 50, DutyTaxFeeCategoryCodeUNTDID5305::STANDARD_RATE),
                    ],
                ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(new InvoiceLineIdentifier('FA-0001')),
                        new SpecifiedTradeProduct('Product 1'),
                        new SpecifiedLineTradeAgreement(new NetPriceProductTradePrice(100)),
                        new SpecifiedLineTradeDelivery(new BilledQuantity(1, UnitOfMeasureCode::BALL)),
                        new SpecifiedLineTradeSettlement(
                            new ApplicableTradeTax(DutyTaxFeeCategoryCodeUNTDID5305::STANDARD_RATE),
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

    #[TestDox('Create Basic profile from XML')]
    #[DataProvider('provideBasicXml')]
    public function testCreateBasicProfileFromXML(string $filename): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/Fixtures/Basic/' . $filename . '.xml'));

        $invoice = CrossIndustryInvoice::fromXML($document);
        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);
    }

    public static function provideBasicXml(): iterable
    {
        yield '#1' => ['CIIBasicInvoice'];
        yield '#2' => ['CIIBasicInvoice_V7_01'];
        yield '#3' => ['CIIBasicInvoice_V7_02'];
        yield '#4' => ['CIIBasicInvoice_V7_03'];
        yield '#5' => ['CIIBasicInvoice_V7_04'];
        yield '#6' => ['CIIBasicInvoice_V7_05'];
        yield '#7' => ['CIIBasicInvoice_V7_06'];
        yield '#8' => ['CIIBasicInvoice_V7_07'];
        yield '#9' => ['CIIBasicInvoice_V7_08'];
        yield '#10' => ['CIIBasicInvoice_V7_09'];
        yield '#11' => ['CIIBasicInvoice_V7_10'];
        yield '#12' => ['CIIBasicInvoice_V7_11'];
    }
}
