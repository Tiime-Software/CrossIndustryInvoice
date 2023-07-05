<?php

namespace Tiime\CrossIndustryInvoice\Tests;

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
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\DataType\BusinessProcessSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\BuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\CategoryTradeTax;
use Tiime\CrossIndustryInvoice\DataType\ContractReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\DefinedTradeContact;
use Tiime\CrossIndustryInvoice\DataType\DespatchAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\DocumentIncludedNote;
use Tiime\CrossIndustryInvoice\DataType\DueDateDateTime;
use Tiime\CrossIndustryInvoice\DataType\EmailURIUniversalCommunication;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\BuyerSpecifiedLegalOrganization;
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
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationVA;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradePaymentTerms;
use Tiime\CrossIndustryInvoice\DataType\StartDateTime;
use Tiime\CrossIndustryInvoice\DataType\TaxPointDate;
use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\CrossIndustryInvoice\DataType\TelephoneUniversalCommunication;
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice;
use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\DataType\ChargeReasonCode;
use Tiime\EN16931\DataType\CountryAlpha2Code;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\DateCode2005;
use Tiime\EN16931\DataType\DateCode2475;
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
use Tiime\EN16931\DataType\Identifier\SellerItemIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\Identifier\StandardItemIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;
use Tiime\EN16931\DataType\InvoiceNoteCode;
use Tiime\EN16931\DataType\InvoiceTypeCode;
use Tiime\EN16931\DataType\ObjectSchemeCode;
use Tiime\EN16931\DataType\PaymentMeansCode;
use Tiime\EN16931\DataType\Reference\ContractReference;
use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;
use Tiime\EN16931\DataType\Reference\PrecedingInvoiceReference;
use Tiime\EN16931\DataType\Reference\PurchaseOrderLineReference;
use Tiime\EN16931\DataType\Reference\PurchaseOrderReference;
use Tiime\EN16931\DataType\Reference\ReceivingAdviceReference;
use Tiime\EN16931\DataType\UnitOfMeasurement;
use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\DataType\VatExoneration;
use Tiime\EN16931\SemanticDataType\Percentage;

class CIIEN16931Test extends TestCase
{
    /**
     * @testdox Create EN-16931 profile with mandatory fields
     */
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
                    new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40),
                    [
                        new HeaderApplicableTradeTax(100, 100, VatCategory::STANDARD),
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
                            new BilledQuantity(1, UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                        ),
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
     * @testdox Create EN16931 profile with mandatory and optional fields
     */
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
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ))
                ->setIncludedNotes([
                    (new DocumentIncludedNote('DocumentIncludedNote'))->setSubjectCode(InvoiceNoteCode::NOTE),
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
                    CurrencyCode::EURO,
                    (new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40))
                        ->setRoundingAmount(40)
                        ->setChargeTotalAmount(20)
                        ->setAllowanceTotalAmount(10)
                        ->setTaxTotalAmountCurrency(new TaxTotalAmount(10, CurrencyCode::EURO))
                        ->setTotalPrepaidAmount(40),
                    [
                        (new HeaderApplicableTradeTax(100, 100, VatCategory::STANDARD))
                            ->setTaxPointDate(new TaxPointDate(new \DateTime()))
                            ->setExemptionReason('ExemptionReason')
                            ->setExemptionReasonCode(VatExoneration::NOT_SUBJECT_TO_VAT)
                            ->setDueDateTypeCode(DateCode2475::INVOICE_DATE)
                            ->setRateApplicablePercent(50),
                    ],
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
                                (new PayeePartyCreditorFinancialAccount())
                                    ->setIbanIdentifier(new PaymentAccountIdentifier('PaymentAccountIdentifier'))
                                    ->setAccountName('accountName')
                                    ->setProprietaryIdentifier(new PaymentAccountIdentifier('PaymentAccountIdentifier (proprietary)'))
                            )
                            ->setPayeeSpecifiedCreditorFinancialInstitution(
                                new PayeeSpecifiedCreditorFinancialInstitution(
                                    new PaymentServiceProviderIdentifier('PaymentServiceProviderIdentifier')
                                )
                            )
                    )
                    ->setBillingSpecifiedPeriod(
                        (new BillingSpecifiedPeriod())
                            ->setStartDateTime(new StartDateTime(new \DateTime()))
                            ->setEndDateTime(new EndDateTime(new \DateTime()))
                    )
                    ->setSpecifiedTradeAllowances([
                        (new SpecifiedTradeAllowance(
                            100,
                            (new CategoryTradeTax(VatCategory::STANDARD))
                                ->setRateApplicablePercent(new Percentage(50))
                        ))
                            ->setBasisAmount(100)
                            ->setReason('ReasonAllowanceHeader1')
                            ->setReasonCode(AllowanceReasonCode::DISCOUNT)
                            ->setCalculationPercent(50),
                    ])
                    ->setSpecifiedTradeCharges([
                        (new SpecifiedTradeCharge(
                            50,
                            (new CategoryTradeTax(VatCategory::STANDARD))
                                ->setRateApplicablePercent(new Percentage(20))
                        ))
                            ->setBasisAmount(50)
                            ->setReason('ReasonChargeHeader1')
                            ->setReasonCode(ChargeReasonCode::ACCEPTANCE)
                            ->setCalculationPercent(20),
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
                    ->setReceivableSpecifiedTradeAccountingAccount(new ReceivableSpecifiedTradeAccountingAccount('ReceivableSpecifiedTradeAccountingAccount')),
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
                                    (new BasisQuantity(100))
                                        ->setUnitCode(UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                                )
                                ->setAppliedTradeAllowanceCharge(new AppliedTradeAllowanceCharge(100))
                        )
                            ->setBuyerOrderReferencedDocument(
                                (new LineBuyerOrderReferencedDocument())
                                    ->setLineIdentifier(new PurchaseOrderLineReference('PurchaseOrderLineReference'))
                            ),
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(1, UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                        ),
                        (new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(VatCategory::STANDARD))
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
                                    ->setReasonCode(AllowanceReasonCode::STANDARD)
                                    ->setBasisAmount(50)
                                    ->setCalculationPercent(100),
                            ])
                            ->setSpecifiedTradeCharges([
                                (new LineSpecifiedTradeCharge(50))
                                    ->setReason('ReasonCharge1')
                                    ->setReasonCode(ChargeReasonCode::ACCEPTANCE)
                                    ->setBasisAmount(50)
                                    ->setCalculationPercent(100),
                            ])
                            ->setReceivableSpecifiedTradeAccountingAccount(new ReceivableSpecifiedTradeAccountingAccount('ReceivableSpecifiedTradeAccountingAccount'))
                            ->setAdditionalReferencedDocument(
                                (new AdditionalReferencedDocumentInvoiceLineObjectIdentifier(
                                    new ObjectIdentifier('AdditionalReferencedDocument', ObjectSchemeCode::ACCOUNT_NUMBER)
                                ))->setReferenceTypeCode(ObjectSchemeCode::ACCOUNT_NUMBER)
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
     * @testdox Create EN16931 profile from XML mandatory data
     */
    public function testCreateEN16931ProfileFromXMLMandatoryData(): void
    {
        $invoiceToConvert = new CrossIndustryInvoice(
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
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE)),
                    new BuyerTradeParty('BuyerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40),
                    [
                        new HeaderApplicableTradeTax(100, 100, VatCategory::STANDARD),
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
                            new BilledQuantity(1, UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                        ),
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
     * @testdox Generate CII HTML with EN-16931 CII
     */
    public function testGenerateHTMLWithEN16931CII(): void
    {
        $invoice = new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::EN16931)
                )
            ),
            (new ExchangedDocument(
                new InvoiceIdentifier('FA-2017-0010'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime('2017-11-13'))
            ))->setIncludedNotes([new DocumentIncludedNote('Franco de port (commande > 300 € HT)')]),
            new SupplyChainTradeTransaction(
                (new ApplicableHeaderTradeAgreement(
                    (new SellerTradeParty(
                        'Au bon moulin',
                        (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                            ->setLineOne('1242 chemin de l\'olive')
                            ->setPostcodeCode('84340')
                            ->setCityName('Malaucène')
                    ))
                        ->setSpecifiedLegalOrganization(
                            (new SellerSpecifiedLegalOrganization())
                                ->setIdentifier(new LegalRegistrationIdentifier('99999999800010', InternationalCodeDesignator::SYSTEM_INFORMATION_ET_REPERTOIRE_DES_ENTREPRISE_ET_DES_ETABLISSEMENTS_SIRENE))
                        )
                        ->setDefinedTradeContact(
                            (new DefinedTradeContact())
                                ->setPersonName('Tony Dubois')
                                ->setTelephoneUniversalCommunication(new TelephoneUniversalCommunication('+33 4 72 07 08 56'))
                                ->setEmailURIUniversalCommunication(new EmailURIUniversalCommunication('tony.dubois@aubonmoulin.fr'))
                        )
                        ->setSpecifiedTaxRegistrationVA(
                            new SpecifiedTaxRegistrationVA(new VatIdentifier('FR11999999998'))
                        )
                    ,
                    (new BuyerTradeParty(
                        'Ma jolie boutique',
                        (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                            ->setPostcodeCode('69001')
                            ->setLineOne('35 rue de la République')
                            ->setCityName('Lyon')
                    ))
                        ->setDefinedTradeContact(
                            (new DefinedTradeContact())
                                ->setPersonName('Alexandre Payet')
                                ->setTelephoneUniversalCommunication(new TelephoneUniversalCommunication('+33 4 72 07 08 67'))
                                ->setEmailURIUniversalCommunication(new EmailURIUniversalCommunication('alexandre.payet@majolieboutique.net'))
                        )
                        ->setSpecifiedLegalOrganization(
                            new BuyerSpecifiedLegalOrganization(
                                new LegalRegistrationIdentifier('78787878400035', InternationalCodeDesignator::SYSTEM_INFORMATION_ET_REPERTOIRE_DES_ENTREPRISE_ET_DES_ETABLISSEMENTS_SIRENE)
                            )
                        )
                        ->setSpecifiedTaxRegistrationVA(
                            new SpecifiedTaxRegistrationVA(
                                new VatIdentifier('FR19787878784')
                            )
                        )
                ))
                    ->setBuyerOrderReferencedDocument(new BuyerOrderReferencedDocument(new PurchaseOrderReference('PO445')))
                    ->setContractReferencedDocument(new ContractReferencedDocument(new ContractReference('MSPE2017')))
                ,
                (new ApplicableHeaderTradeDelivery())
                    ->setShipToTradeParty(
                        (new ShipToTradeParty())->setPostalTradeAddress(
                            (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                                ->setLineOne('35 rue de la République')
                                ->setCityName('Lyon')
                                ->setPostcodeCode('69001')
                        )
                    ),
                (new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    (new SpecifiedTradeSettlementHeaderMonetarySummation(624.90, 624.90, 671.15, 470.15))
                        ->setTaxTotalAmount(new TaxTotalAmount(46.25, CurrencyCode::EURO))
                        ->setTotalPrepaidAmount(201.00),
                    [
                        (new HeaderApplicableTradeTax(16.38, 81.90, VatCategory::STANDARD))
                            ->setRateApplicablePercent(20)
                            ->setDueDateTypeCode(DateCode2475::INVOICE_DATE)
                        ,
                        (new HeaderApplicableTradeTax(29.87, 543, VatCategory::STANDARD))
                            ->setRateApplicablePercent(5.5)
                            ->setDueDateTypeCode(DateCode2475::INVOICE_DATE)
                    ],
                ))
                    ->setPaymentReference('FA-2017-0010')
                    ->setSpecifiedTradeSettlementPaymentMeans(
                        (new SpecifiedTradeSettlementPaymentMeans(PaymentMeansCode::CREDIT_TRANSFER))
                            ->setInformation('Virement sur compte Banque Fiducial')
                            ->setPayeePartyCreditorFinancialAccount(
                                (new PayeePartyCreditorFinancialAccount())
                                    ->setIbanIdentifier(new PaymentAccountIdentifier('FR2012421242124212421242124'))
                            )
                            ->setPayeeSpecifiedCreditorFinancialInstitution(
                                new PayeeSpecifiedCreditorFinancialInstitution(new PaymentServiceProviderIdentifier('FIDCFR21XXX'))
                            )
                    )
                    ->setSpecifiedTradePaymentTerms(
                        (new SpecifiedTradePaymentTerms())
                            ->setDescription('30% d\'acompte, solde à 30 j')
                            ->setDueDateDateTime(new DueDateDateTime(new \DateTimeImmutable('2017-12-13')))
                    ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('1')
                        ),
                        (new SpecifiedTradeProduct('Nougat de l\'Abbaye 250g'))
                            ->setSellerAssignedIdentifier(new SellerItemIdentifier('NOUG250'))
                            ->setGlobalIdentifier(new StandardItemIdentifier('3518370400049', InternationalCodeDesignator::GTIN_GLOBAL_TRADE_ITEM_NUMBER))
                        ,
                        (new SpecifiedLineTradeAgreement(
                            new NetPriceProductTradePrice(4.10)
                        ))
                            ->setGrossPriceProductTradePrice(
                                (new GrossPriceProductTradePrice(4.55))
                                    ->setAppliedTradeAllowanceCharge(
                                        new AppliedTradeAllowanceCharge(0.45)
                                    )
                            )
                        ,
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(20, UnitOfMeasurement::ONE_REC20)
                        ),
                        new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(VatCategory::STANDARD))
                                ->setRateApplicablePercent(20),
                            new SpecifiedTradeSettlementLineMonetarySummation(81.90)
                        )
                    ),
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('2')
                        ),
                        (new SpecifiedTradeProduct('Biscuits aux raisins 300g'))
                            ->setSellerAssignedIdentifier(new SellerItemIdentifier('BRAIS300'))
                            ->setGlobalIdentifier(new StandardItemIdentifier('3518370200090', InternationalCodeDesignator::GTIN_GLOBAL_TRADE_ITEM_NUMBER))
                        ,
                        (new SpecifiedLineTradeAgreement(
                            new NetPriceProductTradePrice(3.20)
                        ))
                            ->setGrossPriceProductTradePrice((new GrossPriceProductTradePrice(3.20)))
                        ,
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(15, UnitOfMeasurement::ONE_REC20)
                        ),
                        new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(VatCategory::STANDARD))
                                ->setRateApplicablePercent(5.50),
                            new SpecifiedTradeSettlementLineMonetarySummation(48)
                        )
                    ),
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('3')
                        ),
                        (new SpecifiedTradeProduct('Huile d\'olive à l\'ancienne'))
                            ->setSellerAssignedIdentifier(new SellerItemIdentifier('HOLANCL'))
                        ,
                        (new SpecifiedLineTradeAgreement(
                            new NetPriceProductTradePrice(19.80)
                        ))
                            ->setGrossPriceProductTradePrice((new GrossPriceProductTradePrice(19.80)))
                        ,
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(25, UnitOfMeasurement::LITRE_REC20)
                        ),
                        new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(VatCategory::STANDARD))
                                ->setRateApplicablePercent(5.50),
                            new SpecifiedTradeSettlementLineMonetarySummation(495)
                        )
                    ),
                ],
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $html = $invoice->toHTML(context: ['invoice_logo' => 'image/invoice_logo.png']);
        $this->assertIsString($html);

        $this_directory = dirname(__FILE__);
        $fp = fopen($this_directory . "/invoice.html", "w");
        fwrite($fp, $html);
        fclose($fp);
    }
}