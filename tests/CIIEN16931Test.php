<?php

namespace Tiime\CrossIndustryInvoice\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\DataType\ActualDeliverySupplyChainEvent;
use Tiime\CrossIndustryInvoice\DataType\AdditionalReferencedDocumentInvoiceLineObjectIdentifier;
use Tiime\CrossIndustryInvoice\DataType\ApplicableTradeSettlementFinancialCard;
use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;
use Tiime\CrossIndustryInvoice\DataType\Basic\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\Basic\AppliedTradeAllowanceCharge;
use Tiime\CrossIndustryInvoice\DataType\Basic\BasisQuantity;
use Tiime\CrossIndustryInvoice\DataType\Basic\BilledQuantity;
use Tiime\CrossIndustryInvoice\DataType\Basic\GrossPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeeSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\DataType\BusinessProcessSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\CategoryTradeTax;
use Tiime\CrossIndustryInvoice\DataType\DespatchAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\DocumentIncludedNote;
use Tiime\CrossIndustryInvoice\DataType\DueDateDateTime;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\BuyerTradeParty;
use Tiime\CrossIndustryInvoice\DataType\EN16931\HeaderApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\EN16931\IncludedSupplyChainTradeLineItem;
use Tiime\CrossIndustryInvoice\DataType\EN16931\LineSpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\EN16931\LineSpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\EN16931\PayeePartyCreditorFinancialAccount;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SellerTradeParty;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedLineTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedLineTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeProduct;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeSettlementPaymentMeans;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SupplyChainTradeTransaction;
use Tiime\CrossIndustryInvoice\DataType\EndDateTime;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;
use Tiime\CrossIndustryInvoice\DataType\FormattedIssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\GuidelineSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\InvoiceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\LineBuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\LocationGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\NetPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\DataType\OccurrenceDateTime;
use Tiime\CrossIndustryInvoice\DataType\PayeeGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\PayeeSpecifiedCreditorFinancialInstitution;
use Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty;
use Tiime\CrossIndustryInvoice\DataType\PayerPartyDebtorFinancialAccount;
use Tiime\CrossIndustryInvoice\DataType\ReceivableSpecifiedTradeAccountingAccount;
use Tiime\CrossIndustryInvoice\DataType\ReceivingAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ShipToTradeParty;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradePaymentTerms;
use Tiime\CrossIndustryInvoice\DataType\StartDateTime;
use Tiime\CrossIndustryInvoice\DataType\TaxPointDate;
use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\Utils\CrossIndustryInvoiceUtils;
use Tiime\EN16931\Codelist\AllowanceReasonCodeUNTDID5189;
use Tiime\EN16931\Codelist\ChargeReasonCodeUNTDID7161;
use Tiime\EN16931\Codelist\CountryAlpha2Code;
use Tiime\EN16931\Codelist\CurrencyCodeISO4217;
use Tiime\EN16931\Codelist\DutyTaxFeeCategoryCodeUNTDID5305;
use Tiime\EN16931\Codelist\InternationalCodeDesignator;
use Tiime\EN16931\Codelist\InvoiceTypeCodeUNTDID1001;
use Tiime\EN16931\Codelist\PaymentMeansCodeUNTDID4461;
use Tiime\EN16931\Codelist\ReferenceQualifierCodeUNTDID1153;
use Tiime\EN16931\Codelist\TextSubjectCodeUNTDID4451;
use Tiime\EN16931\Codelist\TimeReferencingCodeUNTDID2475;
use Tiime\EN16931\Codelist\UnitOfMeasureCode;
use Tiime\EN16931\Codelist\VatExemptionReasonCode;
use Tiime\EN16931\DataType\Identifier\BankAssignedCreditorIdentifier;
use Tiime\EN16931\DataType\Identifier\DebitedAccountIdentifier;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\Identifier\InvoiceLineIdentifier;
use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\LocationIdentifier;
use Tiime\EN16931\DataType\Identifier\MandateReferenceIdentifier;
use Tiime\EN16931\DataType\Identifier\ObjectIdentifier;
use Tiime\EN16931\DataType\Identifier\PayeeIdentifier;
use Tiime\EN16931\DataType\Identifier\PaymentAccountIdentifier;
use Tiime\EN16931\DataType\Identifier\PaymentServiceProviderIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;
use Tiime\EN16931\DataType\Reference\PrecedingInvoiceReference;
use Tiime\EN16931\DataType\Reference\PurchaseOrderLineReference;
use Tiime\EN16931\DataType\Reference\ReceivingAdviceReference;
use Tiime\EN16931\SemanticDataType\Percentage;

class CIIEN16931Test extends TestCase
{
    public function testValidateXsdError(): void
    {
        $xml = "<?xml version='1.0' encoding='UTF-8'?>
            <rsm:CrossIndustryInvoice xmlns:qdt=\"urn:un:unece:uncefact:data:standard:QualifiedDataType:100\" xmlns:ram=\"urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100\" xmlns:rsm=\"urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100\" xmlns:udt=\"urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
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

        $xsdErrors = CrossIndustryInvoiceUtils::validateXSD($document, 'EN16931');

        $this->assertCount(1, $xsdErrors);
    }

    #[DataProvider('provideEN16931Xml')]
    public function testValidateXSDSuccess(string $filename): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/Fixtures/EN16931/' . $filename . '.xml'));

        $xsdErrors = CrossIndustryInvoiceUtils::validateXSD($document, 'EN16931');

        $this->assertCount(0, $xsdErrors);
    }

    #[TestDox('Create EN-16931 profile with mandatory fields')]
    public function testCreateEN16931ProfileWithMandatoryFields(): void
    {
        $invoice = new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::EN16931)
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
                    new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40),
                    [
                        new HeaderApplicableTradeTax(100, 100, DutyTaxFeeCategoryCodeUNTDID5305::STANDARD_RATE),
                    ],
                ),
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
                            new BilledQuantity(1, UnitOfMeasureCode::ACCOUNTING_UNIT)
                        ),
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

    #[TestDox('Create EN16931 profile with mandatory and optional fields')]
    public function testCreateEN16931ProfileWithMandatoryAndOptionalFields(): void
    {
        $invoice = new CrossIndustryInvoice(
            (new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::EN16931)
                )
            ))
                ->setBusinessProcessSpecifiedDocumentContextParameter(new BusinessProcessSpecifiedDocumentContextParameter('BusinessProcess1')),
            (new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCodeUNTDID1001::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ))
                ->setIncludedNotes([
                    (new DocumentIncludedNote('DocumentIncludedNote'))->setSubjectCode(TextSubjectCodeUNTDID4451::NOTE),
                ]),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty(
                        'SellerTradePartyName',
                        (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                            ->setPostcodeCode('PostcodeCode')
                            ->setLineOne('LineOne')
                            ->setLineTwo('LineTwo')
                            ->setLineThree('Line3')
                            ->setCityName('CityName')
                            ->setCountrySubDivisionName('CountrySubDivisionName')
                    ),
                    new BuyerTradeParty(
                        'BuyerTradePartyName',
                        (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                            ->setPostcodeCode('PostcodeCode')
                            ->setLineOne('LineOne')
                            ->setLineTwo('LineTwo')
                            ->setLineThree('Line3')
                            ->setCityName('CityName')
                            ->setCountrySubDivisionName('CountrySubDivisionName')
                    )
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
                        new ActualDeliverySupplyChainEvent(
                            new OccurrenceDateTime(new \DateTime()))
                    )
                    ->setDespatchAdviceReferencedDocument(
                        new DespatchAdviceReferencedDocument(
                            new DespatchAdviceReference('DespatchAdviceReference')
                        )
                    )
                    ->setReceivingAdviceReferencedDocument(
                        new ReceivingAdviceReferencedDocument(
                            new ReceivingAdviceReference('ReceivingAdviceReference')
                        )
                    ),
                (new ApplicableHeaderTradeSettlement(
                    CurrencyCodeISO4217::EURO,
                    (new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40))
                        ->setRoundingAmount(40)
                        ->setChargeTotalAmount(20)
                        ->setAllowanceTotalAmount(10)
                        ->setTaxTotalAmountCurrency(new TaxTotalAmount(10, CurrencyCodeISO4217::EURO))
                        ->setTotalPrepaidAmount(40),
                    [
                        (new HeaderApplicableTradeTax(100, 100, DutyTaxFeeCategoryCodeUNTDID5305::STANDARD_RATE))
                            ->setTaxPointDate(new TaxPointDate(new \DateTime()))
                            ->setExemptionReason('ExemptionReason')
                            ->setExemptionReasonCode(VatExemptionReasonCode::NOT_SUBJECT_TO_VAT)
                            ->setDueDateTypeCode(TimeReferencingCodeUNTDID2475::DATE_OF_INVOICE)
                            ->setRateApplicablePercent(50),
                    ],
                ))
                    ->setCreditorReferenceIdentifier(new BankAssignedCreditorIdentifier('BankAssignedCreditorIdentifier'))
                    ->setPaymentReference('PaymentReference')
                    ->setTaxCurrencyCode(CurrencyCodeISO4217::EURO)
                    ->setPayeeTradeParty(
                        (new PayeeTradeParty('PayeeTradePartyName'))
                            ->setIdentifier(new PayeeIdentifier('PayeeIdentifier'))
                            ->setGlobalIdentifier(new PayeeGlobalIdentifier('PayeeGlobalIdentifier', InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN))
                            ->setSpecifiedLegalOrganization(
                                (new PayeeSpecifiedLegalOrganization())
                                    ->setIdentifier(new LegalRegistrationIdentifier('LegalRegistrationIdentifier', scheme: InternationalCodeDesignator::SYSTEM_INFORMATION_ET_REPERTOIRE_DES_ENTREPRISE_ET_DES_ETABLISSEMENTS_SIRENE))
                            )
                    )
                    ->setSpecifiedTradeSettlementPaymentMeans([
                        (new SpecifiedTradeSettlementPaymentMeans(PaymentMeansCodeUNTDID4461::ACCEPTED_BILL_OF_EXCHANGE))
                            ->setInformation('Information')
                            ->setApplicableTradeSettlementFinancialCard(
                                (new ApplicableTradeSettlementFinancialCard('ApplicableTradeSettlementFinancialCardIdentifier'))
                                    ->setCardholderName('CardholderName')
                            )
                            ->setPayerPartyDebtorFinancialAccount(
                                new PayerPartyDebtorFinancialAccount(
                                    new DebitedAccountIdentifier('DebitedAccountIdentifier')
                                )
                            )
                            ->setPayeePartyCreditorFinancialAccount(
                                (new PayeePartyCreditorFinancialAccount())
                                    ->setIbanIdentifier(new PaymentAccountIdentifier('PaymentAccountIdentifier'))
                                    ->setAccountName('accountName')
                                    ->setProprietaryIdentifier(new PaymentAccountIdentifier('PaymentAccountIdentifier (proprietary)'))
                            )
                            ->setPayeeSpecifiedCreditorFinancialInstitution(
                                new PayeeSpecifiedCreditorFinancialInstitution(
                                    new PaymentServiceProviderIdentifier('PaymentServiceProviderIdentifier')
                                )
                            ),
                    ])
                    ->setBillingSpecifiedPeriod(
                        (new BillingSpecifiedPeriod())
                            ->setStartDateTime(new StartDateTime(new \DateTime()))
                            ->setEndDateTime(new EndDateTime(new \DateTime()))
                    )
                    ->setSpecifiedTradeAllowances([
                        (new SpecifiedTradeAllowance(
                            100,
                            (new CategoryTradeTax(DutyTaxFeeCategoryCodeUNTDID5305::STANDARD_RATE))
                                ->setRateApplicablePercent(new Percentage(50))
                        ))
                            ->setBasisAmount(100)
                            ->setReason('ReasonAllowanceHeader1')
                            ->setReasonCode(AllowanceReasonCodeUNTDID5189::DISCOUNT)
                            ->setCalculationPercent(50),
                    ])
                    ->setSpecifiedTradeCharges([
                        (new SpecifiedTradeCharge(
                            50,
                            (new CategoryTradeTax(DutyTaxFeeCategoryCodeUNTDID5305::STANDARD_RATE))
                                ->setRateApplicablePercent(new Percentage(20))
                        ))
                            ->setBasisAmount(50)
                            ->setReason('ReasonChargeHeader1')
                            ->setReasonCode(ChargeReasonCodeUNTDID7161::ACCEPTANCE)
                            ->setCalculationPercent(20),
                    ])
                    ->setSpecifiedTradePaymentTerms(
                        (new SpecifiedTradePaymentTerms())
                            ->setDirectDebitMandateIdentifier(new MandateReferenceIdentifier('MandateReferenceIdentifier'))
                            ->setDescription('description')
                            ->setDueDateDateTime(new DueDateDateTime(new \DateTime()))
                    )
                    ->setInvoiceReferencedDocuments([
                        (new InvoiceReferencedDocument(
                            new PrecedingInvoiceReference('PrecedingInvoiceReference'))
                        )
                            ->setFormattedIssueDateTime(new FormattedIssueDateTime(new \DateTime())),
                    ])
                    ->setReceivableSpecifiedTradeAccountingAccount(new ReceivableSpecifiedTradeAccountingAccount('ReceivableSpecifiedTradeAccountingAccount')),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('InvoiceLineIdentifier')
                        ),
                        new SpecifiedTradeProduct('SpecifiedTradProduct'),
                        (new SpecifiedLineTradeAgreement(
                            (new NetPriceProductTradePrice(100))->setBasisQuantity((new BasisQuantity(1))->setUnitCode(UnitOfMeasureCode::ACCOUNTING_UNIT))
                        ))->setGrossPriceProductTradePrice(
                            (new GrossPriceProductTradePrice(100))
                                ->setBasisQuantity(
                                    (new BasisQuantity(100))
                                        ->setUnitCode(UnitOfMeasureCode::ACCOUNTING_UNIT)
                                )
                                ->setAppliedTradeAllowanceCharge(new AppliedTradeAllowanceCharge(100))
                        )
                            ->setBuyerOrderReferencedDocument(
                                (new LineBuyerOrderReferencedDocument())
                                    ->setLineIdentifier(new PurchaseOrderLineReference('PurchaseOrderLineReference'))
                            ),
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(1, UnitOfMeasureCode::ACCOUNTING_UNIT)
                        ),
                        (new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(DutyTaxFeeCategoryCodeUNTDID5305::STANDARD_RATE))
                                ->setRateApplicablePercent(20),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        ))
                            ->setBillingSpecifiedPeriod(
                                (new BillingSpecifiedPeriod())
                                    ->setStartDateTime(new StartDateTime(new \DateTime()))
                                    ->setEndDateTime(new EndDateTime(new \DateTime()))
                            )
                            ->setSpecifiedTradeAllowances([
                                (new LineSpecifiedTradeAllowance(50))
                                    ->setReason('ReasonAllowance1')
                                    ->setReasonCode(AllowanceReasonCodeUNTDID5189::STANDARD)
                                    ->setBasisAmount(50)
                                    ->setCalculationPercent(100),
                            ])
                            ->setSpecifiedTradeCharges([
                                (new LineSpecifiedTradeCharge(50))
                                    ->setReason('ReasonCharge1')
                                    ->setReasonCode(ChargeReasonCodeUNTDID7161::ACCEPTANCE)
                                    ->setBasisAmount(50)
                                    ->setCalculationPercent(100),
                            ])
                            ->setReceivableSpecifiedTradeAccountingAccount(new ReceivableSpecifiedTradeAccountingAccount('ReceivableSpecifiedTradeAccountingAccount'))
                            ->setAdditionalReferencedDocument(
                                (new AdditionalReferencedDocumentInvoiceLineObjectIdentifier(
                                    new ObjectIdentifier('AdditionalReferencedDocument', ReferenceQualifierCodeUNTDID1153::ACCOUNT_NUMBER)
                                ))->setReferenceTypeCode(ReferenceQualifierCodeUNTDID1153::ACCOUNT_NUMBER)
                            )
                    ),
                ],
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }

    #[TestDox('Create EN16931 profile from XML')]
    #[DataProvider('provideEN16931Xml')]
    public function testCreateEN16931ProfileFromXML(string $filename): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/Fixtures/EN16931/' . $filename . '.xml'));

        $invoice = CrossIndustryInvoice::fromXML($document);
        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);
    }

    public static function provideEN16931Xml(): iterable
    {
        yield '#1' => ['CIIEN16931Invoice'];
        yield '#2' => ['CIIEN16931Invoice_V7_01'];
        yield '#3' => ['CIIEN16931Invoice_V7_02'];
        yield '#4' => ['CIIEN16931Invoice_V7_03'];
        yield '#5' => ['CIIEN16931Invoice_V7_04'];
        yield '#6' => ['CIIEN16931Invoice_V7_05'];
        yield '#7' => ['CIIEN16931Invoice_V7_06'];
        yield '#8' => ['CIIEN16931Invoice_V7_07'];
        yield '#9' => ['CIIEN16931Invoice_V7_08'];
        yield '#10' => ['CIIEN16931Invoice_V7_09'];
        yield '#11' => ['CIIEN16931Invoice_V7_10'];
        yield '#12' => ['CIIEN16931Invoice_V7_11'];
    }
}
