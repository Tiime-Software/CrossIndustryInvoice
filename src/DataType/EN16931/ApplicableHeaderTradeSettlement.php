<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\DataType\InvoiceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty;
use Tiime\CrossIndustryInvoice\DataType\ReceivableSpecifiedTradeAccountingAccount;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradePaymentTerms;
use Tiime\EN16931\BusinessTermsGroup\InvoicingPeriod;
use Tiime\EN16931\BusinessTermsGroup\Payee;
use Tiime\EN16931\BusinessTermsGroup\PaymentInstructions;
use Tiime\EN16931\Converter\DateCode2005ToDateCode2475Converter;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\DateCode2005;
use Tiime\EN16931\DataType\Identifier\BankAssignedCreditorIdentifier;
use Tiime\EN16931\Invoice;

/**
 * BG-19.
 */
class ApplicableHeaderTradeSettlement extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeSettlement
{
    public function __construct(
        CurrencyCode $invoiceCurrencyCode,
        SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation,
        array $applicableTradeTaxes,
    ) {
        if (0 === \count($applicableTradeTaxes)) {
            throw new \Exception('ApplicableHeaderTradeSettlement should contain at least one HeaderApplicableTradeTax.');
        }

        foreach ($applicableTradeTaxes as $applicableTradeTax) {
            if (!$applicableTradeTax instanceof HeaderApplicableTradeTax) {
                throw new \TypeError();
            }
        }

        parent::__construct($invoiceCurrencyCode, $specifiedTradeSettlementHeaderMonetarySummation, $applicableTradeTaxes);
    }

    public function getSpecifiedTradeSettlementHeaderMonetarySummation(): SpecifiedTradeSettlementHeaderMonetarySummation
    {
        $specifiedTradeSettlementHeaderMonetarySummation = parent::getSpecifiedTradeSettlementHeaderMonetarySummation();

        if (!$specifiedTradeSettlementHeaderMonetarySummation instanceof SpecifiedTradeSettlementHeaderMonetarySummation) {
            throw new \LogicException('Must be of type EN16931\\SpecifiedTradeSettlementHeaderMonetarySummation');
        }

        return $specifiedTradeSettlementHeaderMonetarySummation;
    }

    public function getApplicableTradeTaxes(): array
    {
        $applicableTradeTaxes = parent::getApplicableTradeTaxes();

        foreach ($applicableTradeTaxes as $applicableTradeTax) {
            if (!$applicableTradeTax instanceof HeaderApplicableTradeTax) {
                throw new \LogicException('Must be of type EN16931\\HeaderApplicableTradeTax');
            }
        }

        return $applicableTradeTaxes;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->creditorReferenceIdentifier instanceof BankAssignedCreditorIdentifier) {
            $currentNode->appendChild($document->createElement('ram:CreditorReferenceID', $this->creditorReferenceIdentifier->value));
        }

        if (\is_string($this->paymentReference)) {
            $currentNode->appendChild($document->createElement('ram:PaymentReference', $this->paymentReference));
        }

        if ($this->taxCurrencyCode instanceof CurrencyCode) {
            $currentNode->appendChild($document->createElement('ram:TaxCurrencyCode', $this->taxCurrencyCode->value));
        }

        $currentNode->appendChild($document->createElement('ram:InvoiceCurrencyCode', $this->invoiceCurrencyCode->value));

        if ($this->payeeTradeParty instanceof PayeeTradeParty) {
            $currentNode->appendChild($this->payeeTradeParty->toXML($document));
        }

        foreach ($this->specifiedTradeSettlementPaymentMeans as $specifiedTradeSettlementPaymentMeansItem) {
            $currentNode->appendChild($specifiedTradeSettlementPaymentMeansItem->toXML($document));
        }

        foreach ($this->applicableTradeTaxes as $applicableTradeTax) {
            $currentNode->appendChild($applicableTradeTax->toXML($document));
        }

        if ($this->billingSpecifiedPeriod instanceof BillingSpecifiedPeriod) {
            $currentNode->appendChild($this->billingSpecifiedPeriod->toXML($document));
        }

        foreach ($this->specifiedTradeAllowances as $specifiedTradeAllowance) {
            $currentNode->appendChild($specifiedTradeAllowance->toXML($document));
        }

        foreach ($this->specifiedTradeCharges as $specifiedTradeCharge) {
            $currentNode->appendChild($specifiedTradeCharge->toXML($document));
        }

        if ($this->specifiedTradePaymentTerms instanceof SpecifiedTradePaymentTerms) {
            $currentNode->appendChild($this->specifiedTradePaymentTerms->toXML($document));
        }

        $currentNode->appendChild($this->specifiedTradeSettlementHeaderMonetarySummation->toXML($document));

        foreach ($this->invoiceReferencedDocuments as $invoiceReferencedDocument) {
            $currentNode->appendChild($invoiceReferencedDocument->toXML($document));
        }

        if ($this->receivableSpecifiedTradeAccountingAccount instanceof ReceivableSpecifiedTradeAccountingAccount) {
            $currentNode->appendChild($this->receivableSpecifiedTradeAccountingAccount->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $applicableHeaderTradeSettlementElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeSettlementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeSettlementElement */
        $applicableHeaderTradeSettlementElement = $applicableHeaderTradeSettlementElements->item(0);

        $creditorReferenceIdentifierElements = $xpath->query('./ram:CreditorReferenceID', $applicableHeaderTradeSettlementElement);
        $paymentReferenceElements            = $xpath->query('./ram:PaymentReference', $applicableHeaderTradeSettlementElement);
        $taxCurrencyCodeElements             = $xpath->query('./ram:TaxCurrencyCode', $applicableHeaderTradeSettlementElement);
        $invoiceCurrencyCodeElements         = $xpath->query('./ram:InvoiceCurrencyCode', $applicableHeaderTradeSettlementElement);

        if ($creditorReferenceIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($paymentReferenceElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($taxCurrencyCodeElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $invoiceCurrencyCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        $invoiceCurrencyCode = CurrencyCode::tryFrom($invoiceCurrencyCodeElements->item(0)->nodeValue);

        if (!$invoiceCurrencyCode instanceof CurrencyCode) {
            throw new \Exception('Wrong InvoiceCurrencyCode');
        }

        $payeeTradeParty                                 = PayeeTradeParty::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $specifiedTradeSettlementPaymentMeans            = SpecifiedTradeSettlementPaymentMeans::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $applicableTradeTaxes                            = HeaderApplicableTradeTax::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $billingSpecifiedPeriod                          = BillingSpecifiedPeriod::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $specifiedTradeAllowances                        = SpecifiedTradeAllowance::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $specifiedTradeCharges                           = SpecifiedTradeCharge::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $specifiedTradePaymentTerms                      = SpecifiedTradePaymentTerms::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $specifiedTradeSettlementHeaderMonetarySummation = SpecifiedTradeSettlementHeaderMonetarySummation::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $invoiceReferencedDocuments                      = InvoiceReferencedDocument::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $receivableSpecifiedTradeAccountingAccount       = ReceivableSpecifiedTradeAccountingAccount::fromXML($xpath, $applicableHeaderTradeSettlementElement);

        $applicableHeaderTradeSettlement = new self($invoiceCurrencyCode, $specifiedTradeSettlementHeaderMonetarySummation, $applicableTradeTaxes);

        if (1 === $creditorReferenceIdentifierElements->count()) {
            $applicableHeaderTradeSettlement->setCreditorReferenceIdentifier(new BankAssignedCreditorIdentifier($creditorReferenceIdentifierElements->item(0)->nodeValue));
        }

        if (1 === $paymentReferenceElements->count()) {
            $applicableHeaderTradeSettlement->setPaymentReference($paymentReferenceElements->item(0)->nodeValue);
        }

        if (1 === $taxCurrencyCodeElements->count()) {
            $taxCurrencyCode = CurrencyCode::tryFrom($taxCurrencyCodeElements->item(0)->nodeValue);

            if (!$taxCurrencyCode instanceof CurrencyCode) {
                throw new \Exception('Wrong TaxCurrencyCode');
            }

            $applicableHeaderTradeSettlement->setTaxCurrencyCode($taxCurrencyCode);
        }

        if ($payeeTradeParty instanceof PayeeTradeParty) {
            $applicableHeaderTradeSettlement->setPayeeTradeParty($payeeTradeParty);
        }

        if (\count($specifiedTradeSettlementPaymentMeans) > 0) {
            $applicableHeaderTradeSettlement->setSpecifiedTradeSettlementPaymentMeans($specifiedTradeSettlementPaymentMeans);
        }

        if ($billingSpecifiedPeriod instanceof BillingSpecifiedPeriod) {
            $applicableHeaderTradeSettlement->setBillingSpecifiedPeriod($billingSpecifiedPeriod);
        }

        if (\count($specifiedTradeAllowances) > 0) {
            $applicableHeaderTradeSettlement->setSpecifiedTradeAllowances($specifiedTradeAllowances);
        }

        if (\count($specifiedTradeCharges) > 0) {
            $applicableHeaderTradeSettlement->setSpecifiedTradeCharges($specifiedTradeCharges);
        }

        if ($specifiedTradePaymentTerms instanceof SpecifiedTradePaymentTerms) {
            $applicableHeaderTradeSettlement->setSpecifiedTradePaymentTerms($specifiedTradePaymentTerms);
        }

        if (\count($invoiceReferencedDocuments) > 0) {
            $applicableHeaderTradeSettlement->setInvoiceReferencedDocuments($invoiceReferencedDocuments);
        }

        if ($receivableSpecifiedTradeAccountingAccount instanceof ReceivableSpecifiedTradeAccountingAccount) {
            $applicableHeaderTradeSettlement->setReceivableSpecifiedTradeAccountingAccount($receivableSpecifiedTradeAccountingAccount);
        }

        return $applicableHeaderTradeSettlement;
    }

    public static function fromEN16931(Invoice $invoice): self
    {
        $applicableTradeTaxes     = [];
        $specifiedTradeAllowances = [];
        $specifiedTradeCharges    = [];

        foreach ($invoice->getVatBreakdowns() as $vatBreakdown) {
            $applicableTradeTaxes[] = HeaderApplicableTradeTax::fromEN16931(
                $vatBreakdown,
                $invoice->getValueAddedTaxPointDateCode() instanceof DateCode2005
                    ? DateCode2005ToDateCode2475Converter::convert($invoice->getValueAddedTaxPointDateCode())
                    : null
            );
        }

        foreach ($invoice->getDocumentLevelAllowances() as $allowance) {
            $specifiedTradeAllowances[] = SpecifiedTradeAllowance::fromEN16931($allowance);
        }

        foreach ($invoice->getDocumentLevelCharges() as $charge) {
            $specifiedTradeCharges[] = SpecifiedTradeCharge::fromEN16931($charge);
        }

        $applicableHeaderTradeSettlement = new self(
            $invoice->getCurrencyCode(),
            SpecifiedTradeSettlementHeaderMonetarySummation::fromEN16931($invoice),
            $applicableTradeTaxes,
        );

        $applicableHeaderTradeSettlement
            ->setCreditorReferenceIdentifier($invoice->getPaymentInstructions()?->getDirectDebit()?->getBankAssignedCreditorIdentifier())
            ->setPaymentReference($invoice->getPaymentInstructions()?->getRemittanceInformation())
            ->setTaxCurrencyCode($invoice->getVatAccountingCurrencyCode())
            ->setPayeeTradeParty(
                $invoice->getPayee() instanceof Payee
                    ? PayeeTradeParty::fromEN16931($invoice->getPayee())
                    : null
            )
            ->setSpecifiedTradeSettlementPaymentMeans(
                $invoice->getPaymentInstructions() instanceof PaymentInstructions
                    ? SpecifiedTradeSettlementPaymentMeans::fromEN16931($invoice->getPaymentInstructions())
                    : []
            )
            ->setBillingSpecifiedPeriod(
                $invoice->getDeliveryInformation()?->getInvoicingPeriod() instanceof InvoicingPeriod
                    ? BillingSpecifiedPeriod::fromEN16931($invoice->getDeliveryInformation()->getInvoicingPeriod())
                    : null
            )
            ->setSpecifiedTradeAllowances($specifiedTradeAllowances)
            ->setSpecifiedTradeCharges($specifiedTradeCharges)
            ->setSpecifiedTradePaymentTerms(SpecifiedTradePaymentTerms::fromEN16931($invoice))
            ->setInvoiceReferencedDocuments(
                \count($invoice->getPrecedingInvoices()) > 0
                    ? InvoiceReferencedDocument::fromEN16931($invoice)
                    : null
            )
            ->setReceivableSpecifiedTradeAccountingAccount(
                \is_string($invoice->getBuyerAccountingReference())
                    ? ReceivableSpecifiedTradeAccountingAccount::fromEN16931($invoice)
                    : null
            );

        return $applicableHeaderTradeSettlement;
    }
}
