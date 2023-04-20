<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\HeaderApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\DataType\InvoiceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty;
use Tiime\CrossIndustryInvoice\DataType\ReceivableSpecifiedTradeAccountingAccount;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradePaymentTerms;
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
    private ?BankAssignedCreditorIdentifier $creditorReferenceId;

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
     * @var non-empty-array<int, HeaderApplicableTradeTax>
     *
     * TODO : constructor 1..n checks
     */
    private array $applicableTradeTaxes;

    /**
     * BG-14.
     */
    private ?BillingSpecifiedPeriod $billingSpecifiedPeriod;

    /**
     * BG-20.
     *
     * @var array<int, SpecifiedTradeAllowance>
     */
    private array $specifiedTradeAllowances;

    /**
     * BG-21.
     *
     * @var array<int, SpecifiedTradeCharge>
     */
    private array $specifiedTradeCharges;

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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ApplicableHeaderTradeSettlement');

        $element->appendChild($document->createElement('ram:CreditorReferenceID', $this->creditorReferenceId->value));

        if (\is_string($this->paymentReference)) {
            $element->appendChild($document->createElement('ram:PaymentReference', $this->paymentReference));
        }

        if ($this->taxCurrencyCode instanceof CurrencyCode) {
            $element->appendChild($document->createElement('ram:TaxCurrencyCode', $this->taxCurrencyCode->value));
        }

        $element->appendChild($document->createElement('ram:InvoiceCurrencyCode', $this->invoiceCurrencyCode->value));

        if ($this->payeeTradeParty instanceof PayeeTradeParty) {
            $element->appendChild($this->payeeTradeParty->toXML($document));
        }

        if ($this->specifiedTradeSettlementPaymentMeans instanceof SpecifiedTradeSettlementPaymentMeans) {
            $element->appendChild($this->specifiedTradeSettlementPaymentMeans->toXML($document));
        }

        foreach ($this->applicableTradeTaxes as $applicableTradeTax) {
            $element->appendChild($applicableTradeTax->toXML($document));
        }

        if ($this->billingSpecifiedPeriod instanceof BillingSpecifiedPeriod) {
            $element->appendChild($this->billingSpecifiedPeriod->toXML($document));
        }

        foreach ($this->specifiedTradeAllowances as $specifiedTradeAllowance) {
            $element->appendChild($specifiedTradeAllowance->toXML($document));
        }

        foreach ($this->specifiedTradeCharges as $specifiedTradeCharge) {
            $element->appendChild($specifiedTradeCharge->toXML($document));
        }

        if ($this->specifiedTradePaymentTerms instanceof SpecifiedTradePaymentTerms) {
            $element->appendChild($this->specifiedTradePaymentTerms->toXML($document));
        }

        $element->appendChild($this->specifiedTradeSettlementHeaderMonetarySummation->toXML($document));

        if ($this->invoiceReferencedDocument instanceof InvoiceReferencedDocument) {
            $element->appendChild($this->invoiceReferencedDocument->toXML($document));
        }

        if ($this->receivableSpecifiedTradeAccountingAccount instanceof ReceivableSpecifiedTradeAccountingAccount) {
            $element->appendChild($this->receivableSpecifiedTradeAccountingAccount->toXML($document));
        }

        return $element;
    }
}
