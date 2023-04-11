<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-22.
 */
class SpecifiedTradeSettlementHeaderMonetarySummation
{
    /**
     * BT-109.
     */
    private Amount $taxBasisTotalAmount;

    /**
     * BT-110 & BT-110-0.
     */
    private ?TaxTotalAmount $taxTotalAmount;

    /**
     * BT-112.
     */
    private Amount $grandTotalAmount;

    /**
     * BT-115.
     */
    private Amount $amountDueForPayment;

    public function __construct(
        float $taxBasisTotalAmount,
        float $grandTotalAmount,
        float $amountDueForPayment,
        TaxTotalAmount $taxTotalAmount = null
    ) {
        $this->taxBasisTotalAmount = new Amount($taxBasisTotalAmount);
        $this->grandTotalAmount    = new Amount($grandTotalAmount);
        $this->amountDueForPayment = new Amount($amountDueForPayment);
        $this->taxTotalAmount      = $taxTotalAmount;
    }

    public function getTaxBasisTotalAmount(): float
    {
        return $this->taxBasisTotalAmount->getValueRounded();
    }

    public function getTaxTotalAmount(): ?TaxTotalAmount
    {
        return $this->taxTotalAmount;
    }

    public function getGrandTotalAmount(): float
    {
        return $this->grandTotalAmount->getValueRounded();
    }

    public function getAmountDueForPayment(): float
    {
        return $this->amountDueForPayment->getValueRounded();
    }
}
