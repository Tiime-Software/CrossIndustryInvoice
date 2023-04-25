<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\AdditionalReferencedDocument;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\ReceivableSpecifiedTradeAccountingAccount;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\SpecifiedTradeCharge;

/**
 * BG-30-00.
 */
class SpecifiedLineTradeSettlement
{
    /**
     * BG-30.
     */
    private ApplicableTradeTax $applicableTradeTax;

    /**
     * BG-26.
     */
    private ?BillingSpecifiedPeriod $billingSpecifiedPeriod;

    /**
     * BG-27.
     *
     * @var array<int, SpecifiedTradeAllowance>
     */
    private array $specifiedTradeAllowances;

    /**
     * BG-28.
     *
     * @var array<int, SpecifiedTradeCharge>
     */
    private array $specifiedTradeCharges;

    /**
     * BT-131-00.
     */
    private SpecifiedTradeSettlementLineMonetarySummation $specifiedTradeSettlementLineMonetarySummation;

    /**
     * BT-128-00.
     */
    private ?AdditionalReferencedDocument $additionalReferencedDocument;

    /**
     * BT-133-00.
     */
    private ?ReceivableSpecifiedTradeAccountingAccount $receivableSpecifiedTradeAccountingAccount;

    public function __construct(ApplicableTradeTax $applicableTradeTax, SpecifiedTradeSettlementLineMonetarySummation $specifiedTradeSettlementLineMonetarySummation)
    {
        $this->applicableTradeTax                            = $applicableTradeTax;
        $this->specifiedTradeSettlementLineMonetarySummation = $specifiedTradeSettlementLineMonetarySummation;
        $this->specifiedTradeAllowances                      = [];
        $this->specifiedTradeCharges                         = [];
        $this->billingSpecifiedPeriod                        = null;
        $this->additionalReferencedDocument                  = null;
        $this->receivableSpecifiedTradeAccountingAccount     = null;
    }

    public function getApplicableTradeTax(): ApplicableTradeTax
    {
        return $this->applicableTradeTax;
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

    public function getSpecifiedTradeSettlementLineMonetarySummation(): SpecifiedTradeSettlementLineMonetarySummation
    {
        return $this->specifiedTradeSettlementLineMonetarySummation;
    }

    public function getAdditionalReferencedDocument(): ?AdditionalReferencedDocument
    {
        return $this->additionalReferencedDocument;
    }

    public function setAdditionalReferencedDocument(?AdditionalReferencedDocument $additionalReferencedDocument): static
    {
        $this->additionalReferencedDocument = $additionalReferencedDocument;

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
        $element = $document->createElement('ram:SpecifiedLineTradeSettlement');

        $element->appendChild($this->applicableTradeTax->toXML($document));

        if (null !== $this->billingSpecifiedPeriod) {
            $element->appendChild($this->billingSpecifiedPeriod->toXML($document));
        }

        foreach ($this->specifiedTradeAllowances as $specifiedTradeAllowance) {
            $element->appendChild($specifiedTradeAllowance->toXML($document));
        }

        foreach ($this->specifiedTradeCharges as $specifiedTradeCharge) {
            $element->appendChild($specifiedTradeCharge->toXML($document));
        }

        $element->appendChild($this->specifiedTradeSettlementLineMonetarySummation->toXML($document));

        if ($this->additionalReferencedDocument instanceof AdditionalReferencedDocument) {
            $element->appendChild($this->additionalReferencedDocument->toXML($document));
        }

        if ($this->receivableSpecifiedTradeAccountingAccount instanceof ReceivableSpecifiedTradeAccountingAccount) {
            $element->appendChild($this->receivableSpecifiedTradeAccountingAccount->toXML($document));
        }

        return $element;
    }
}
