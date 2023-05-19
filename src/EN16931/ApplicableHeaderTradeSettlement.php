<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\DataType\EN16931\HeaderApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\InvoiceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty;
use Tiime\CrossIndustryInvoice\DataType\ReceivableSpecifiedTradeAccountingAccount;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradePaymentTerms;
use Tiime\EN16931\BusinessTermsGroup\InvoicingPeriod;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\Identifier\BankAssignedCreditorIdentifier;
use Tiime\EN16931\Invoice;

/**
 * BG-19.
 */
class ApplicableHeaderTradeSettlement
{
    protected const XML_NODE = 'ram:ApplicableHeaderTradeSettlement';

    /**
     * BT-90.
     */
    private ?BankAssignedCreditorIdentifier $creditorReferenceIdentifier;

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

    public function __construct(CurrencyCode $invoiceCurrencyCode, array $applicableTradeTaxes, SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation)
    {
        $tmpApplicableTradeTaxes = [];

        foreach ($applicableTradeTaxes as $applicableTradeTax) {
            if (!$applicableTradeTax instanceof HeaderApplicableTradeTax) {
                throw new \TypeError();
            }

            $tmpApplicableTradeTaxes[] = $applicableTradeTax;
        }

        if (0 === \count($tmpApplicableTradeTaxes)) {
            throw new \Exception('ApplicableHeaderTradeSettlement should contain at least one HeaderApplicableTradeTax.');
        }

        $this->invoiceCurrencyCode                             = $invoiceCurrencyCode;
        $this->applicableTradeTaxes                            = $tmpApplicableTradeTaxes;
        $this->specifiedTradeSettlementHeaderMonetarySummation = $specifiedTradeSettlementHeaderMonetarySummation;
        $this->creditorReferenceIdentifier                     = null;
        $this->paymentReference                                = null;
        $this->taxCurrencyCode                                 = null;
        $this->payeeTradeParty                                 = null;
        $this->specifiedTradeSettlementPaymentMeans            = null;
        $this->billingSpecifiedPeriod                          = null;
        $this->specifiedTradePaymentTerms                      = null;
        $this->invoiceReferencedDocument                       = null;
        $this->receivableSpecifiedTradeAccountingAccount       = null;
        $this->specifiedTradeAllowances                        = [];
        $this->specifiedTradeCharges                           = [];
    }

    public function getCreditorReferenceIdentifier(): ?BankAssignedCreditorIdentifier
    {
        return $this->creditorReferenceIdentifier;
    }

    public function setCreditorReferenceIdentifier(?BankAssignedCreditorIdentifier $creditorReferenceIdentifier): static
    {
        $this->creditorReferenceIdentifier = $creditorReferenceIdentifier;

        return $this;
    }

    public function getPaymentReference(): ?string
    {
        return $this->paymentReference;
    }

    public function setPaymentReference(?string $paymentReference): static
    {
        $this->paymentReference = $paymentReference;

        return $this;
    }

    public function getTaxCurrencyCode(): ?CurrencyCode
    {
        return $this->taxCurrencyCode;
    }

    public function setTaxCurrencyCode(?CurrencyCode $taxCurrencyCode): static
    {
        $this->taxCurrencyCode = $taxCurrencyCode;

        return $this;
    }

    public function getInvoiceCurrencyCode(): CurrencyCode
    {
        return $this->invoiceCurrencyCode;
    }

    public function getPayeeTradeParty(): ?PayeeTradeParty
    {
        return $this->payeeTradeParty;
    }

    public function setPayeeTradeParty(?PayeeTradeParty $payeeTradeParty): static
    {
        $this->payeeTradeParty = $payeeTradeParty;

        return $this;
    }

    public function getSpecifiedTradeSettlementPaymentMeans(): ?SpecifiedTradeSettlementPaymentMeans
    {
        return $this->specifiedTradeSettlementPaymentMeans;
    }

    public function setSpecifiedTradeSettlementPaymentMeans(?SpecifiedTradeSettlementPaymentMeans $specifiedTradeSettlementPaymentMeans): static
    {
        $this->specifiedTradeSettlementPaymentMeans = $specifiedTradeSettlementPaymentMeans;

        return $this;
    }

    public function getApplicableTradeTaxes(): array
    {
        return $this->applicableTradeTaxes;
    }

    public function getBillingSpecifiedPeriod(): ?BillingSpecifiedPeriod
    {
        return $this->billingSpecifiedPeriod;
    }

    public function setBillingSpecifiedPeriod(?BillingSpecifiedPeriod $billingSpecifiedPeriod): static
    {
        $this->billingSpecifiedPeriod = $billingSpecifiedPeriod;

        return $this;
    }

    public function getSpecifiedTradeAllowances(): array
    {
        return $this->specifiedTradeAllowances;
    }

    public function setSpecifiedTradeAllowances(array $specifiedTradeAllowances): static
    {
        $tmpSpecifiedTradeAllowances = [];

        foreach ($specifiedTradeAllowances as $specifiedTradeAllowance) {
            if (!$specifiedTradeAllowance instanceof SpecifiedTradeAllowance) {
                throw new \TypeError();
            }
            $tmpSpecifiedTradeAllowances[] = $specifiedTradeAllowance;
        }

        $this->specifiedTradeAllowances = $tmpSpecifiedTradeAllowances;

        return $this;
    }

    public function getSpecifiedTradeCharges(): array
    {
        return $this->specifiedTradeCharges;
    }

    public function setSpecifiedTradeCharges(array $specifiedTradeCharges): static
    {
        $tmpSpecifiedTradeCharges = [];

        foreach ($specifiedTradeCharges as $specifiedTradeCharge) {
            if (!$specifiedTradeCharge instanceof SpecifiedTradeCharge) {
                throw new \TypeError();
            }
            $tmpSpecifiedTradeCharges[] = $specifiedTradeCharge;
        }

        $this->specifiedTradeCharges = $tmpSpecifiedTradeCharges;

        return $this;
    }

    public function getSpecifiedTradePaymentTerms(): ?SpecifiedTradePaymentTerms
    {
        return $this->specifiedTradePaymentTerms;
    }

    public function setSpecifiedTradePaymentTerms(?SpecifiedTradePaymentTerms $specifiedTradePaymentTerms): static
    {
        $this->specifiedTradePaymentTerms = $specifiedTradePaymentTerms;

        return $this;
    }

    public function getSpecifiedTradeSettlementHeaderMonetarySummation(): SpecifiedTradeSettlementHeaderMonetarySummation
    {
        return $this->specifiedTradeSettlementHeaderMonetarySummation;
    }

    public function getInvoiceReferencedDocument(): ?InvoiceReferencedDocument
    {
        return $this->invoiceReferencedDocument;
    }

    public function setInvoiceReferencedDocument(?InvoiceReferencedDocument $invoiceReferencedDocument): static
    {
        $this->invoiceReferencedDocument = $invoiceReferencedDocument;

        return $this;
    }

    public function getReceivableSpecifiedTradeAccountingAccount(): ?ReceivableSpecifiedTradeAccountingAccount
    {
        return $this->receivableSpecifiedTradeAccountingAccount;
    }

    public function setReceivableSpecifiedTradeAccountingAccount(?ReceivableSpecifiedTradeAccountingAccount $receivableSpecifiedTradeAccountingAccount): static
    {
        $this->receivableSpecifiedTradeAccountingAccount = $receivableSpecifiedTradeAccountingAccount;

        return $this;
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

        if ($this->specifiedTradeSettlementPaymentMeans instanceof SpecifiedTradeSettlementPaymentMeans) {
            $currentNode->appendChild($this->specifiedTradeSettlementPaymentMeans->toXML($document));
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

        if ($this->invoiceReferencedDocument instanceof InvoiceReferencedDocument) {
            $currentNode->appendChild($this->invoiceReferencedDocument->toXML($document));
        }

        if ($this->receivableSpecifiedTradeAccountingAccount instanceof ReceivableSpecifiedTradeAccountingAccount) {
            $currentNode->appendChild($this->receivableSpecifiedTradeAccountingAccount->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $applicableHeaderTradeSettlementElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeSettlementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeSettlementElement */
        $applicableHeaderTradeSettlementElement = $applicableHeaderTradeSettlementElements->item(0);

        $creditorReferenceIdentifierElements = $xpath->query('.//ram:CreditorReferenceID', $applicableHeaderTradeSettlementElement);
        $paymentReferenceElements            = $xpath->query('.//ram:PaymentReference', $applicableHeaderTradeSettlementElement);
        $taxCurrencyCodeElements             = $xpath->query('.//ram:TaxCurrencyCode', $applicableHeaderTradeSettlementElement);
        $invoiceCurrencyCodeElements         = $xpath->query('.//ram:InvoiceCurrencyCode', $applicableHeaderTradeSettlementElement);

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
        $invoiceReferencedDocument                       = InvoiceReferencedDocument::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $receivableSpecifiedTradeAccountingAccount       = ReceivableSpecifiedTradeAccountingAccount::fromXML($xpath, $applicableHeaderTradeSettlementElement);

        $applicableHeaderTradeSettlement = new self($invoiceCurrencyCode, $applicableTradeTaxes, $specifiedTradeSettlementHeaderMonetarySummation);

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

        if ($specifiedTradeSettlementPaymentMeans instanceof SpecifiedTradeSettlementPaymentMeans) {
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

        if ($invoiceReferencedDocument instanceof InvoiceReferencedDocument) {
            $applicableHeaderTradeSettlement->setInvoiceReferencedDocument($invoiceReferencedDocument);
        }

        if ($receivableSpecifiedTradeAccountingAccount instanceof ReceivableSpecifiedTradeAccountingAccount) {
            $applicableHeaderTradeSettlement->setReceivableSpecifiedTradeAccountingAccount($receivableSpecifiedTradeAccountingAccount);
        }

        return $applicableHeaderTradeSettlement;
    }

    public static function fromEN16931(Invoice $invoice): static
    {
        $applicableTradeTaxes     = [];
        $specifiedTradeAllowances = [];
        $specifiedTradeCharges    = [];

        foreach ($invoice->getVatBreakdowns() as $vatBreakdown) {
            $applicableTradeTaxes[] = HeaderApplicableTradeTax::fromEN16931(
                $vatBreakdown,
                $invoice->getValueAddedTaxPointDateCode()
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
            $applicableTradeTaxes,
            SpecifiedTradeSettlementHeaderMonetarySummation::fromEN16931($invoice->getDocumentTotals())
        );

        $applicableHeaderTradeSettlement
            ->setCreditorReferenceIdentifier($invoice->getPaymentInstructions()?->getDirectDebit()?->getBankAssignedCreditorIdentifier())
            ->setPaymentReference($invoice->getPaymentInstructions()?->getRemittanceInformation())
            ->setTaxCurrencyCode($invoice->getVatAccountingCurrencyCode())
            ->setPayeeTradeParty(PayeeTradeParty::fromEN16931($invoice->getPayee()))
            ->setSpecifiedTradeSettlementPaymentMeans(SpecifiedTradeSettlementPaymentMeans::fromEN16931($invoice->getPaymentInstructions()))
            ->setBillingSpecifiedPeriod(
                $invoice->getDeliveryInformation()?->getInvoicingPeriod() instanceof InvoicingPeriod
                    ? BillingSpecifiedPeriod::fromEN16931($invoice->getDeliveryInformation()->getInvoicingPeriod())
                    : null
            )
            ->setSpecifiedTradeAllowances($specifiedTradeAllowances)
            ->setSpecifiedTradeCharges($specifiedTradeCharges)
            ->setSpecifiedTradePaymentTerms(SpecifiedTradePaymentTerms::fromEN16931($invoice))
            ->setInvoiceReferencedDocument(
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
