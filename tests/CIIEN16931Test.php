<?php

namespace Tests\Tiime\CrossIndustryInvoice;

use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\DataType\ActualDeliverySupplyChainEvent;
use Tiime\CrossIndustryInvoice\DataType\ApplicableTradeSettlementFinancialCard;
use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;
use Tiime\CrossIndustryInvoice\DataType\Basic\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\Basic\GrossPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeeSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BusinessProcessSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\CategoryTradeTax;
use Tiime\CrossIndustryInvoice\DataType\DespatchAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\DocumentIncludedNote;
use Tiime\CrossIndustryInvoice\DataType\DueDateDateTime;
use Tiime\CrossIndustryInvoice\DataType\EN16931\HeaderApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\EN16931\PayeePartyCreditorFinancialAccount;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;
use Tiime\CrossIndustryInvoice\DataType\FormattedIssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\GuidelineSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\InvoiceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\LocationGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\OccurrenceDateTime;
use Tiime\CrossIndustryInvoice\DataType\PayeeGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\PayeeSpecifiedCreditorFinancialInstitution;
use Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty;
use Tiime\CrossIndustryInvoice\DataType\PayerPartyDebtorFinancialAccount;
use Tiime\CrossIndustryInvoice\DataType\ShipToTradeParty;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradePaymentTerms;
use Tiime\CrossIndustryInvoice\DataType\TaxPointDate;
use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\EN16931\AppliedTradeAllowanceCharge;
use Tiime\CrossIndustryInvoice\EN16931\BilledQuantity;
use Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty;
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\EN16931\EndDateTime;
use Tiime\CrossIndustryInvoice\EN16931\IncludedSupplyChainTradeLineItem;
use Tiime\CrossIndustryInvoice\EN16931\NetPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\EN16931\NetPriceProductTradePrice\BasisQuantity;
use Tiime\CrossIndustryInvoice\EN16931\ReceivingAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeAgreement;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeAgreement\BuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\AdditionalReferencedDocument;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\InvoiceLineAllowances\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\InvoiceLineCharges\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\ReceivableSpecifiedTradeAccountingAccount;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedTradeProduct;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedTradeSettlementPaymentMeans;
use Tiime\CrossIndustryInvoice\EN16931\StartDateTime;
use Tiime\CrossIndustryInvoice\EN16931\SupplyChainTradeTransaction;
use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\DataType\ChargeReasonCode;
use Tiime\EN16931\DataType\CountryAlpha2Code;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\DateCode2005;
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
use Tiime\EN16931\DataType\InternationalCodeDesignator;
use Tiime\EN16931\DataType\InvoiceNoteCode;
use Tiime\EN16931\DataType\InvoiceTypeCode;
use Tiime\EN16931\DataType\ObjectSchemeCode;
use Tiime\EN16931\DataType\PaymentMeansCode;
use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;
use Tiime\EN16931\DataType\Reference\PrecedingInvoiceReference;
use Tiime\EN16931\DataType\Reference\PurchaseOrderLineReference;
use Tiime\EN16931\DataType\Reference\ReceivingAdviceReference;
use Tiime\EN16931\DataType\UnitOfMeasurement;
use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\DataType\VatExoneration;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

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

    /**
     * @test
     * @testdox Create EN16931 profile with mandatory and optional fields
     */
    public function createEN16931ProfileWithMandatoryAndOptionalFields(): void
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
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ))
                ->setIncludedNotes([
                    (new DocumentIncludedNote('DocumentIncludedNote'))->setSubjectCode(InvoiceNoteCode::NOTE)
                ]),
            new SupplyChainTradeTransaction(
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('InvoiceLineIdentifier')
                        ),
                        new SpecifiedTradeProduct('SpecifiedTradProduct'),
                        (new SpecifiedLineTradeAgreement(
                            (new NetPriceProductTradePrice(100))->setBasisQuantity((new BasisQuantity(1))->setUnitCode(UnitOfMeasurement::ACCOUNTING_UNIT_REC20))
                        ))->setGrossPriceProductTradePrice(
                            (new GrossPriceProductTradePrice(100))
                                ->setBasisQuantity(
                                    (new \Tiime\CrossIndustryInvoice\EN16931\GrossPriceProductTradePrice\BasisQuantity(100))
                                        ->setUnitCode(UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                                )
                                ->setAppliedTradeAllowanceCharge(new AppliedTradeAllowanceCharge(100))
                        )
                            ->setBuyerOrderReferencedDocument((new BuyerOrderReferencedDocument())->setLineIdentifier(new PurchaseOrderLineReference('PurchaseOrderLineReference'))),
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(1, UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                        ),
                        (new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(VatCategory::STANDARD))
                                ->setRateApplicablePercent(new Percentage(20)),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        ))
                            ->setBillingSpecifiedPeriod(
                                (new BillingSpecifiedPeriod())
                                    ->setStartDateTime(new StartDateTime(new \DateTime()))
                                    ->setEndDateTime(new EndDateTime(new \DateTime()))
                            )
                            ->setSpecifiedTradeAllowances([
                                (new SpecifiedTradeAllowance(50))
                                    ->setReason('Reason')
                                    ->setReasonCode(AllowanceReasonCode::STANDARD)
                                    ->setBasisAmount(50)
                                    ->setCalculationPercent(100)
                            ])
                            ->setSpecifiedTradeCharges([
                                (new SpecifiedTradeCharge(50))
                                    ->setReason('Reason')
                                    ->setReasonCode(ChargeReasonCode::ACCEPTANCE)
                                    ->setBasisAmount(50)
                                    ->setCalculationPercent(100)
                            ])
                            ->setReceivableSpecifiedTradeAccountingAccount(new ReceivableSpecifiedTradeAccountingAccount('ReceivableSpecifiedTradeAccountingAccount'))
                            ->setAdditionalReferencedDocument(
                                (new AdditionalReferencedDocument(
                                    new ObjectIdentifier('AdditionalReferencedDocument', ObjectSchemeCode::ACCOUNT_NUMBER)
                                ))->setReferenceTypeCode(ObjectSchemeCode::ACCOUNT_NUMBER)
                            )
                    )
                ],
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
                    CurrencyCode::EURO,
                    [
                        (new HeaderApplicableTradeTax(100, 100, VatCategory::STANDARD))
                            ->setTaxPointDate(new TaxPointDate(new \DateTime()))
                            ->setExemptionReason('ExemptionReason')
                            ->setExemptionReasonCode(VatExoneration::NOT_SUBJECT_TO_VAT)
                            ->setDueDateTypeCode(DateCode2005::INVOICE_DATE_TIME)
                            ->setRateApplicablePercent(new Percentage(50))
                    ],
                    (new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40))
                        ->setRoundingAmount(40)
                        ->setChargeTotalAmount(20)
                        ->setAllowanceTotalAmount(10)
                        ->setTaxTotalAmountCurrency(new TaxTotalAmount(10, CurrencyCode::EURO))
                        ->setTotalPrepaidAmount(40)
                ))
                    ->setCreditorReferenceIdentifier(new BankAssignedCreditorIdentifier('BankAssignedCreditorIdentifier'))
                    ->setPaymentReference('PaymentReference')
                    ->setTaxCurrencyCode(CurrencyCode::EURO)
                    ->setPayeeTradeParty(
                        (new PayeeTradeParty('PayeeTradePartyName'))
                            ->setIdentifier(new PayeeIdentifier('PayeeIdentifier'))
                            ->setGlobalIdentifier(new PayeeGlobalIdentifier('PayeeGlobalIdentifier', InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN))
                            ->setSpecifiedLegalOrganization(
                                new PayeeSpecifiedLegalOrganization(
                                    new LegalRegistrationIdentifier('LegalRegistrationIdentifier', InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN)
                                )
                            )
                    )
                    ->setSpecifiedTradeSettlementPaymentMeans(
                        (new SpecifiedTradeSettlementPaymentMeans(PaymentMeansCode::ACCEPTED_BILL_OF_EXCHANGE))
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
                            new PayeePartyCreditorFinancialAccount(
                                new PaymentAccountIdentifier('PaymentAccountIdentifier'),
                                'accountName',
                                new PaymentAccountIdentifier('PaymentAccountIdentifier (proprietary)')
                            )
                        )
                        ->setPayeeSpecifiedCreditorFinancialInstitution(
                            new PayeeSpecifiedCreditorFinancialInstitution(
                                new PaymentServiceProviderIdentifier('PaymentServiceProviderIdentifier')
                            )
                        )
                    )
                    ->setBillingSpecifiedPeriod(
                        (new \Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod())
                            ->setStartDateTime(new \Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod\StartDateTime(new \DateTime()))
                            ->setEndDateTime(new \Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod\EndDateTime(new \DateTime()))
                    )
                    ->setSpecifiedTradeAllowances([
                        (new \Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeAllowance(
                            100,
                            (new CategoryTradeTax(VatCategory::STANDARD))
                                ->setRateApplicablePercent(new Percentage(50))
                        ))
                            ->setBasisAmount(new Amount(100))
                            ->setReason('Reason')
                            ->setReasonCode(AllowanceReasonCode::DISCOUNT)
                            ->setCalculationPercent(new Percentage(50))
                    ])
                    ->setSpecifiedTradeCharges([
                        (new \Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeCharge(
                            50,
                            (new CategoryTradeTax(VatCategory::STANDARD))
                                ->setRateApplicablePercent(new Percentage(20))
                        ))
                            ->setBasisAmount(new Amount(50))
                            ->setReason('Reason')
                            ->setReasonCode(ChargeReasonCode::ACCEPTANCE)
                            ->setCalculationPercentage(new Percentage(20))
                    ])
                    ->setSpecifiedTradePaymentTerms(
                        (new SpecifiedTradePaymentTerms())
                            ->setDirectDebitMandateIdentifier(new MandateReferenceIdentifier('MandateReferenceIdentifier'))
                            ->setDescription('description')
                            ->setDueDateDateTime(new DueDateDateTime(new \DateTime()))
                    )
                    ->setInvoiceReferencedDocument(
                        (new InvoiceReferencedDocument(
                            new PrecedingInvoiceReference('PrecedingInvoiceReference'))
                        )
                            ->setFormattedIssueDateTime(new FormattedIssueDateTime(new \DateTime()))
                    )
                    ->setReceivableSpecifiedTradeAccountingAccount(new \Tiime\CrossIndustryInvoice\DataType\ReceivableSpecifiedTradeAccountingAccount('ReceivableSpecifiedTradeAccountingAccount'))
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }
}