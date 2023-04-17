<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-22.
 */
class SpecifiedTradeSettlementHeaderMonetarySummation
{
    /**
     * BT-106.
     */
    private Amount $lineTotalAmount;

    /**
     * BT-108.
     */
    private ?Amount $chargeTotalAmount;

    /**
     * BT-107.
     */
    private ?Amount $allowanceTotalAmount;

    /**
     * BT-109.
     */
    private Amount $taxBasisTotalAmount;

    /**
     * BT-110 & BT-110-0.
     */
    private ?TaxTotalAmount $taxTotalAmount;

    /**
     * BT-111 & BT-111-0.
     */
    private ?TaxTotalAmount $taxTotalAmountCurrency;

    /**
     * BT-114.
     */
    private ?Amount $roundingAmount;

    /**
     * BT-112.
     */
    private Amount $grandTotalAmount;

    /**
     * BT-113.
     */
    private ?Amount $totalPrepaidAmount;

    /**
     * BT-115.
     */
    private Amount $duePayableAmount;

    public function __construct(Amount $lineTotalAmount, Amount $taxBasisTotalAmount, Amount $grandTotalAmount, Amount $duePayableAmount)
    {
        $this->lineTotalAmount        = $lineTotalAmount;
        $this->taxBasisTotalAmount    = $taxBasisTotalAmount;
        $this->grandTotalAmount       = $grandTotalAmount;
        $this->duePayableAmount       = $duePayableAmount;
        $this->chargeTotalAmount      = null;
        $this->allowanceTotalAmount   = null;
        $this->taxTotalAmount         = null;
        $this->taxTotalAmountCurrency = null;
        $this->roundingAmount         = null;
        $this->totalPrepaidAmount     = null;
    }

    public function getLineTotalAmount(): Amount
    {
        return $this->lineTotalAmount;
    }

    public function getChargeTotalAmount(): ?Amount
    {
        return $this->chargeTotalAmount;
    }

    public function setChargeTotalAmount(?Amount $chargeTotalAmount): void
    {
        $this->chargeTotalAmount = $chargeTotalAmount;
    }

    public function getAllowanceTotalAmount(): ?Amount
    {
        return $this->allowanceTotalAmount;
    }

    public function setAllowanceTotalAmount(?Amount $allowanceTotalAmount): void
    {
        $this->allowanceTotalAmount = $allowanceTotalAmount;
    }

    public function getTaxBasisTotalAmount(): Amount
    {
        return $this->taxBasisTotalAmount;
    }

    public function getTaxTotalAmount(): ?TaxTotalAmount
    {
        return $this->taxTotalAmount;
    }

    public function setTaxTotalAmount(?TaxTotalAmount $taxTotalAmount): void
    {
        $this->taxTotalAmount = $taxTotalAmount;
    }

    public function getTaxTotalAmountCurrency(): ?TaxTotalAmount
    {
        return $this->taxTotalAmountCurrency;
    }

    public function setTaxTotalAmountCurrency(?TaxTotalAmount $taxTotalAmountCurrency): void
    {
        $this->taxTotalAmountCurrency = $taxTotalAmountCurrency;
    }

    public function getRoundingAmount(): ?Amount
    {
        return $this->roundingAmount;
    }

    public function setRoundingAmount(?Amount $roundingAmount): void
    {
        $this->roundingAmount = $roundingAmount;
    }

    public function getGrandTotalAmount(): Amount
    {
        return $this->grandTotalAmount;
    }

    public function getTotalPrepaidAmount(): ?Amount
    {
        return $this->totalPrepaidAmount;
    }

    public function setTotalPrepaidAmount(?Amount $totalPrepaidAmount): void
    {
        $this->totalPrepaidAmount = $totalPrepaidAmount;
    }

    public function getDuePayableAmount(): Amount
    {
        return $this->duePayableAmount;
    }
}
