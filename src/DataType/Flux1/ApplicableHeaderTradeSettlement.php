<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Flux1;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\HeaderApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\DataType\InvoiceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradePaymentTerms;
use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\Codelist\CurrencyCodeISO4217;

/**
 * BG-19.
 */
class ApplicableHeaderTradeSettlement
{
    protected const string XML_NODE = 'ram:ApplicableHeaderTradeSettlement';

    /**
     * BG-23.
     *
     * @var non-empty-array<int, HeaderApplicableTradeTax>
     */
    protected array $applicableTradeTaxes;

    /**
     * BG-14.
     */
    protected ?BillingSpecifiedPeriod $billingSpecifiedPeriod;

    /**
     * BG-20.
     *
     * @var array<int, SpecifiedTradeAllowance>
     */
    protected array $specifiedTradeAllowances;

    /**
     * BG-21.
     *
     * @var array<int, SpecifiedTradeCharge>
     */
    protected array $specifiedTradeCharges;

    /**
     * BT-20-00.
     */
    protected ?SpecifiedTradePaymentTerms $specifiedTradePaymentTerms;

    /**
     * BG-3.
     *
     * @var array<int, InvoiceReferencedDocument>
     */
    protected array $invoiceReferencedDocuments;

    /**
     * @param array<int, HeaderApplicableTradeTax> $applicableTradeTaxes
     *
     * @throws \Exception
     */
    public function __construct(
        protected CurrencyCodeISO4217 $invoiceCurrencyCode,
        protected SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation,
        array $applicableTradeTaxes,
    ) {
        if (empty($applicableTradeTaxes)) {
            throw new \Exception('ApplicableHeaderTradeSettlement should contain at least one HeaderApplicableTradeTax.');
        }

        foreach ($applicableTradeTaxes as $applicableTradeTax) {
            if (!$applicableTradeTax instanceof HeaderApplicableTradeTax) {
                throw new \TypeError();
            }
        }

        $this->applicableTradeTaxes       = $applicableTradeTaxes;
        $this->billingSpecifiedPeriod     = null;
        $this->specifiedTradePaymentTerms = null;
        $this->invoiceReferencedDocuments = [];
        $this->specifiedTradeAllowances   = [];
        $this->specifiedTradeCharges      = [];
    }

    public function getInvoiceCurrencyCode(): CurrencyCodeISO4217
    {
        return $this->invoiceCurrencyCode;
    }

    public function getSpecifiedTradeSettlementHeaderMonetarySummation(): SpecifiedTradeSettlementHeaderMonetarySummation
    {
        return $this->specifiedTradeSettlementHeaderMonetarySummation;
    }

    /**
     * @return HeaderApplicableTradeTax[]
     */
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

    /**
     * @return SpecifiedTradeAllowance[]
     */
    public function getSpecifiedTradeAllowances(): array
    {
        return $this->specifiedTradeAllowances;
    }

    /**
     * @param array<int, SpecifiedTradeAllowance> $specifiedTradeAllowances
     */
    public function setSpecifiedTradeAllowances(array $specifiedTradeAllowances): static
    {
        foreach ($specifiedTradeAllowances as $specifiedTradeAllowance) {
            if (!$specifiedTradeAllowance instanceof SpecifiedTradeAllowance) {
                throw new \TypeError();
            }
        }

        $this->specifiedTradeAllowances = $specifiedTradeAllowances;

        return $this;
    }

    /**
     * @return SpecifiedTradeCharge[]
     */
    public function getSpecifiedTradeCharges(): array
    {
        return $this->specifiedTradeCharges;
    }

    /**
     * @param array<int, SpecifiedTradeCharge> $specifiedTradeCharges
     */
    public function setSpecifiedTradeCharges(array $specifiedTradeCharges): static
    {
        foreach ($specifiedTradeCharges as $specifiedTradeCharge) {
            if (!$specifiedTradeCharge instanceof SpecifiedTradeCharge) {
                throw new \TypeError();
            }
        }

        $this->specifiedTradeCharges = $specifiedTradeCharges;

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

    /**
     * @return InvoiceReferencedDocument[]
     */
    public function getInvoiceReferencedDocuments(): array
    {
        return $this->invoiceReferencedDocuments;
    }

    /**
     * @param array<int, InvoiceReferencedDocument> $invoiceReferencedDocuments
     */
    public function setInvoiceReferencedDocuments(array $invoiceReferencedDocuments): static
    {
        foreach ($invoiceReferencedDocuments as $invoiceReferencedDocument) {
            if (!$invoiceReferencedDocument instanceof InvoiceReferencedDocument) {
                throw new \TypeError();
            }
        }

        $this->invoiceReferencedDocuments = $invoiceReferencedDocuments;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:InvoiceCurrencyCode', $this->invoiceCurrencyCode->value));

        foreach ($this->applicableTradeTaxes as $applicableTradeTax) {
            $currentNode->appendChild($applicableTradeTax->toXML($document));
        }

        if ($this->billingSpecifiedPeriod instanceof BillingSpecifiedPeriod) {
            $billingSpecifiedPeriodXml = $this->billingSpecifiedPeriod->toXML($document);

            if ($billingSpecifiedPeriodXml instanceof \DOMElement) {
                $currentNode->appendChild($billingSpecifiedPeriodXml);
            }
        }

        foreach ($this->specifiedTradeAllowances as $specifiedTradeAllowance) {
            $currentNode->appendChild($specifiedTradeAllowance->toXML($document));
        }

        foreach ($this->specifiedTradeCharges as $specifiedTradeCharge) {
            $currentNode->appendChild($specifiedTradeCharge->toXML($document));
        }

        if ($this->specifiedTradePaymentTerms instanceof SpecifiedTradePaymentTerms) {
            $specifiedTradePaymentTermsXml = $this->specifiedTradePaymentTerms->toXML($document);

            if ($specifiedTradePaymentTermsXml instanceof \DOMElement) {
                $currentNode->appendChild($specifiedTradePaymentTermsXml);
            }
        }

        $currentNode->appendChild($this->specifiedTradeSettlementHeaderMonetarySummation->toXML($document));

        foreach ($this->invoiceReferencedDocuments as $invoiceReferencedDocument) {
            $currentNode->appendChild($invoiceReferencedDocument->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
    {
        $applicableHeaderTradeSettlementElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeSettlementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeSettlementElement */
        $applicableHeaderTradeSettlementElement = $applicableHeaderTradeSettlementElements->item(0);

        $invoiceCurrencyCodeElements = $xpath->query('./ram:InvoiceCurrencyCode', $applicableHeaderTradeSettlementElement);

        if (1 !== $invoiceCurrencyCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        $invoiceCurrencyCode = CurrencyCodeISO4217::tryFrom($invoiceCurrencyCodeElements->item(0)->nodeValue);

        if (null === $invoiceCurrencyCode) {
            throw new \Exception('Wrong InvoiceCurrencyCode');
        }

        $applicableTradeTaxes                            = HeaderApplicableTradeTax::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $billingSpecifiedPeriod                          = BillingSpecifiedPeriod::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $specifiedTradeAllowances                        = SpecifiedTradeAllowance::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $specifiedTradeCharges                           = SpecifiedTradeCharge::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $specifiedTradePaymentTerms                      = SpecifiedTradePaymentTerms::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $specifiedTradeSettlementHeaderMonetarySummation = SpecifiedTradeSettlementHeaderMonetarySummation::fromXML($xpath, $applicableHeaderTradeSettlementElement);
        $invoiceReferencedDocuments                      = InvoiceReferencedDocument::fromXML($xpath, $applicableHeaderTradeSettlementElement);

        $applicableHeaderTradeSettlement = new self($invoiceCurrencyCode, $specifiedTradeSettlementHeaderMonetarySummation, $applicableTradeTaxes);

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

        return $applicableHeaderTradeSettlement;
    }
}
