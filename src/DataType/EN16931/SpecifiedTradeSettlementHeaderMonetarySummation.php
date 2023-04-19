<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-22.
 */
class SpecifiedTradeSettlementHeaderMonetarySummation extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\SpecifiedTradeSettlementHeaderMonetarySummation
{
    /**
     * BT-114.
     */
    private ?Amount $roundingAmount;

    public function __construct(
        float $taxBasisTotalAmount,
        float $lineTotalAmount,
        float $grandTotalAmount,
        float $amountDueForPayment,
        TaxTotalAmount $taxTotalAmount = null,
    ) {
        parent::__construct($taxBasisTotalAmount, $lineTotalAmount, $grandTotalAmount, $amountDueForPayment, $taxTotalAmount);

        $this->roundingAmount = null;
    }

    public function getRoundingAmount(): ?float
    {
        return $this->roundingAmount instanceof Amount ? $this->roundingAmount->getValueRounded() : null;
    }

    public function setRoundingAmount(?float $roundingAmount): void
    {
        $this->roundingAmount = is_float($roundingAmount) ? new Amount($roundingAmount) : null;
    }
}
