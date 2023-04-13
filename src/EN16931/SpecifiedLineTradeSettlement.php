<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\InvoiceLineAllowances\SpecifiedTradeAllowanceCharge;

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
     * @var array<int, SpecifiedTradeAllowanceCharge>
     */
    private array $specifiedTradeAllowanceCharges;

    public function __construct(ApplicableTradeTax $applicableTradeTax)
    {
        $this->applicableTradeTax             = $applicableTradeTax;
        $this->specifiedTradeAllowanceCharges = [];
        $this->billingSpecifiedPeriod         = null;
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
}
