<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-22.
 */
class SpecifiedTradeSettlementHeaderMonetarySummation extends \Tiime\CrossIndustryInvoice\DataType\Minimum\SpecifiedTradeSettlementHeaderMonetarySummation
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
     * BT-111 & BT-111-0.
     */
    private ?TaxTotalAmount $taxTotalAmountCurrency;

    /**
     * BT-113.
     */
    private ?Amount $totalPrepaidAmount;

    public function __construct(
        float $taxBasisTotalAmount,
        float $lineTotalAmount,
        float $grandTotalAmount,
        float $amountDueForPayment,
        TaxTotalAmount $taxTotalAmount = null,
    ) {
        parent::__construct($taxBasisTotalAmount, $grandTotalAmount, $amountDueForPayment, $taxTotalAmount);

        $this->lineTotalAmount = new Amount($lineTotalAmount);

        $this->chargeTotalAmount      = null;
        $this->allowanceTotalAmount   = null;
        $this->taxTotalAmountCurrency = null;
        $this->totalPrepaidAmount     = null;
    }

    public function getLineTotalAmount(): float
    {
        return $this->lineTotalAmount->getValueRounded();
    }

    public function setLineTotalAmount(float $lineTotalAmount): void
    {
        $this->lineTotalAmount = new Amount($lineTotalAmount);
    }

    public function getChargeTotalAmount(): ?float
    {
        return $this->chargeTotalAmount instanceof Amount ? $this->chargeTotalAmount->getValueRounded() : null;
    }

    public function setChargeTotalAmount(?float $chargeTotalAmount = null): void
    {
        $this->chargeTotalAmount = \is_float($chargeTotalAmount) ? new Amount($chargeTotalAmount) : null;
    }

    public function getAllowanceTotalAmount(): ?float
    {
        return $this->allowanceTotalAmount instanceof Amount ? $this->allowanceTotalAmount->getValueRounded() : null;
    }

    public function setAllowanceTotalAmount(?float $allowanceTotalAmount): void
    {
        $this->allowanceTotalAmount = \is_float($allowanceTotalAmount) ? new Amount($allowanceTotalAmount) : null;
    }

    public function getTaxTotalAmountCurrency(): ?TaxTotalAmount
    {
        return $this->taxTotalAmountCurrency;
    }

    public function setTaxTotalAmountCurrency(?TaxTotalAmount $taxTotalAmountCurrency): void
    {
        $this->taxTotalAmountCurrency = $taxTotalAmountCurrency;
    }

    public function getTotalPrepaidAmount(): ?float
    {
        return $this->totalPrepaidAmount instanceof Amount ? $this->totalPrepaidAmount->getValueRounded() : null;
    }

    public function setTotalPrepaidAmount(?float $totalPrepaidAmount): void
    {
        $this->totalPrepaidAmount = \is_float($totalPrepaidAmount) ? new Amount($totalPrepaidAmount) : null;
    }
}
