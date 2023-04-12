<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement\SpecifiedTradeAllowanceCharge;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\Identifier\BankAssignedCreditorIdentifier;

/**
 * BG-19.
 */
class ApplicableHeaderTradeSettlement
{
    /**
     * BT-90.
     */
    private ?BankAssignedCreditorIdentifier $creditorReferenceID;

    /**
     * BT-83.
     */
    private ?string $paymentReference;

    /**
     * BT-6.
     */
    private ?CurrencyCode $taxCurrencyCode;

    /**
     * BT-5.
     */
    private CurrencyCode $invoiceCurrencyCode;

    /**
     * BG-10.
     */
    private ?PayeeTradeParty $payeeTradeParty;

    /**
     * BG-16.
     */
    private ?SpecifiedTradeSettlementPaymentMeans $specifiedTradeSettlementPaymentMeans;

    /**
     * BG-23.
     *
     * @var array<int, ApplicableTradeTax>
     */
    private array $applicableTradeTaxes;

    /**
     * BG-14.
     */
    private ?BillingSpecifiedPeriod $billingSpecifiedPeriod;

    /**
     * BG-20.
     *
     * @var array<int, SpecifiedTradeAllowanceCharge>
     *
     * TODO : line 266 and line 278 ???
     */
    private array $specifiedTradeAllowanceCharges;

    /**
     * BT-20-00.
     */
    private ?SpecifiedTradePaymentTerms $specifiedTradePaymentTerms;

    /**
     * BG-22.
     */
    private SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation;

    /**
     * BG-3.
     */
    private ?InvoiceReferencedDocument $invoiceReferencedDocument;

    /**
     * BT-19-00.
     */
    private ?ReceivableSpecifiedTradeAccountingAccount $receivableSpecifiedTradeAccountingAccount;

    public function __construct(CurrencyCode $invoiceCurrencyCode, array $applicableTradeTaxes, SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation)
    {
        $tmpApplicableTradeTaxes = [];

        foreach ($applicableTradeTaxes as $applicableTradeTax) {
            if (!$applicableTradeTax instanceof ApplicableTradeTax) {
                throw new \TypeError();
            }

            $tmpApplicableTradeTaxes[] = $applicableTradeTax;
        }

        if (empty($tmpApplicableTradeTaxes)) {
            throw new \Exception('ApplicableHeaderTradeSettlement should contain at least one ApplicableTradeTax.');
        }

        $this->invoiceCurrencyCode                             = $invoiceCurrencyCode;
        $this->applicableTradeTaxes                            = $tmpApplicableTradeTaxes;
        $this->specifiedTradeSettlementHeaderMonetarySummation = $specifiedTradeSettlementHeaderMonetarySummation;
        $this->creditorReferenceID                             = null;
        $this->paymentReference                                = null;
        $this->taxCurrencyCode                                 = null;
        $this->payeeTradeParty                                 = null;
        $this->specifiedTradeSettlementPaymentMeans            = null;
        $this->billingSpecifiedPeriod                          = null;
        $this->specifiedTradePaymentTerms                      = null;
        $this->invoiceReferencedDocument                       = null;
        $this->receivableSpecifiedTradeAccountingAccount       = null;
        $this->specifiedTradeAllowanceCharges                  = [];
    }

    public function getCreditorReferenceID(): ?BankAssignedCreditorIdentifier
    {
        return $this->creditorReferenceID;
    }

    public function setCreditorReferenceID(?BankAssignedCreditorIdentifier $creditorReferenceID): void
    {
        $this->creditorReferenceID = $creditorReferenceID;
    }

    public function getPaymentReference(): ?string
    {
        return $this->paymentReference;
    }

    public function setPaymentReference(?string $paymentReference): void
    {
        $this->paymentReference = $paymentReference;
    }

    public function getTaxCurrencyCode(): ?CurrencyCode
    {
        return $this->taxCurrencyCode;
    }

    public function setTaxCurrencyCode(?CurrencyCode $taxCurrencyCode): void
    {
        $this->taxCurrencyCode = $taxCurrencyCode;
    }

    public function getInvoiceCurrencyCode(): CurrencyCode
    {
        return $this->invoiceCurrencyCode;
    }

    public function getPayeeTradeParty(): ?PayeeTradeParty
    {
        return $this->payeeTradeParty;
    }

    public function setPayeeTradeParty(?PayeeTradeParty $payeeTradeParty): void
    {
        $this->payeeTradeParty = $payeeTradeParty;
    }

    public function getSpecifiedTradeSettlementPaymentMeans(): ?SpecifiedTradeSettlementPaymentMeans
    {
        return $this->specifiedTradeSettlementPaymentMeans;
    }

    public function setSpecifiedTradeSettlementPaymentMeans(?SpecifiedTradeSettlementPaymentMeans $specifiedTradeSettlementPaymentMeans): void
    {
        $this->specifiedTradeSettlementPaymentMeans = $specifiedTradeSettlementPaymentMeans;
    }

    public function getApplicableTradeTaxes(): array
    {
        return $this->applicableTradeTaxes;
    }

    public function getBillingSpecifiedPeriod(): ?BillingSpecifiedPeriod
    {
        return $this->billingSpecifiedPeriod;
    }

    public function setBillingSpecifiedPeriod(?BillingSpecifiedPeriod $billingSpecifiedPeriod): void
    {
        $this->billingSpecifiedPeriod = $billingSpecifiedPeriod;
    }

    public function getSpecifiedTradeAllowanceCharges(): array
    {
        return $this->specifiedTradeAllowanceCharges;
    }

    public function setSpecifiedTradeAllowanceCharges(array $specifiedTradeAllowanceCharges): void
    {
        $tmpSpecifiedTradeAllowanceCharges = [];

        foreach ($specifiedTradeAllowanceCharges as $specifiedTradeAllowanceCharge) {
            if (!$specifiedTradeAllowanceCharge instanceof SpecifiedTradeAllowanceCharge) {
                throw new \TypeError();
            }
            $tmpSpecifiedTradeAllowanceCharges[] = $specifiedTradeAllowanceCharge;
        }

        $this->specifiedTradeAllowanceCharges = $tmpSpecifiedTradeAllowanceCharges;
    }

    public function getSpecifiedTradePaymentTerms(): ?SpecifiedTradePaymentTerms
    {
        return $this->specifiedTradePaymentTerms;
    }

    public function setSpecifiedTradePaymentTerms(?SpecifiedTradePaymentTerms $specifiedTradePaymentTerms): void
    {
        $this->specifiedTradePaymentTerms = $specifiedTradePaymentTerms;
    }

    public function getSpecifiedTradeSettlementHeaderMonetarySummation(): SpecifiedTradeSettlementHeaderMonetarySummation
    {
        return $this->specifiedTradeSettlementHeaderMonetarySummation;
    }

    public function getInvoiceReferencedDocument(): ?InvoiceReferencedDocument
    {
        return $this->invoiceReferencedDocument;
    }

    public function setInvoiceReferencedDocument(?InvoiceReferencedDocument $invoiceReferencedDocument): void
    {
        $this->invoiceReferencedDocument = $invoiceReferencedDocument;
    }

    public function getReceivableSpecifiedTradeAccountingAccount(): ?ReceivableSpecifiedTradeAccountingAccount
    {
        return $this->receivableSpecifiedTradeAccountingAccount;
    }

    public function setReceivableSpecifiedTradeAccountingAccount(?ReceivableSpecifiedTradeAccountingAccount $receivableSpecifiedTradeAccountingAccount): void
    {
        $this->receivableSpecifiedTradeAccountingAccount = $receivableSpecifiedTradeAccountingAccount;
    }
}
