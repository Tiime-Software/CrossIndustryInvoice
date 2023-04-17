<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\AdditionalReferencedDocument;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\InvoiceLineAllowances\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\InvoiceLineCharges\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\ReceivableSpecifiedTradeAccountingAccount;

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

    public function setBillingSpecifiedPeriod(?BillingSpecifiedPeriod $billingSpecifiedPeriod): void
    {
        $this->billingSpecifiedPeriod = $billingSpecifiedPeriod;
    }

    public function getSpecifiedTradeAllowances(): array
    {
        return $this->specifiedTradeAllowances;
    }

    public function setSpecifiedTradeAllowances(array $specifiedTradeAllowances): void
    {
        $tmpSpecifiedTradeAllowances = [];

        foreach ($specifiedTradeAllowances as $specifiedTradeAllowance) {
            if (!$specifiedTradeAllowance instanceof SpecifiedTradeAllowance) {
                throw new \TypeError();
            }
            $tmpSpecifiedTradeAllowances[] = $specifiedTradeAllowance;
        }

        $this->specifiedTradeAllowances = $tmpSpecifiedTradeAllowances;
    }

    public function getSpecifiedTradeCharges(): array
    {
        return $this->specifiedTradeCharges;
    }

    public function setSpecifiedTradeCharges(array $specifiedTradeCharges): void
    {
        $tmpSpecifiedTradeCharges = [];

        foreach ($specifiedTradeCharges as $specifiedTradeCharge) {
            if (!$specifiedTradeCharge instanceof SpecifiedTradeCharge) {
                throw new \TypeError();
            }
            $tmpSpecifiedTradeCharges[] = $specifiedTradeCharge;
        }

        $this->specifiedTradeCharges = $tmpSpecifiedTradeCharges;
    }

    public function getSpecifiedTradeSettlementLineMonetarySummation(): SpecifiedTradeSettlementLineMonetarySummation
    {
        return $this->specifiedTradeSettlementLineMonetarySummation;
    }

    public function getAdditionalReferencedDocument(): ?AdditionalReferencedDocument
    {
        return $this->additionalReferencedDocument;
    }

    public function setAdditionalReferencedDocument(?AdditionalReferencedDocument $additionalReferencedDocument): void
    {
        $this->additionalReferencedDocument = $additionalReferencedDocument;
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
