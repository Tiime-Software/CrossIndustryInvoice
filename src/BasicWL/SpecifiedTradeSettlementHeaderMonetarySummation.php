<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;

/**
 * BG-22.
 */
class SpecifiedTradeSettlementHeaderMonetarySummation
{
    /**
     * BT-106.
     */
    private float $lineTotalAmount;

    /**
     * BT-108.
     */
    private ?float $chargeTotalAmount;

    /**
     * BT-107.
     */
    private ?float $allowanceTotalAmount;

    /**
     * BT-109.
     */
    private float $taxBasisTotalAmount;

    /**
     * BT-110.
     */
    private ?TaxTotalAmount $taxTotalAmount;

    /**
     * BT-111.
     */
    private ?TaxTotalAmount $taxTotalAmountInAccountingCurrency;

    /**
     * BT-112.
     */
    private float $grandTotalAmount;

    /**
     * BT-113.
     */
    private ?float $totalPrepaidAmount;

    /**
     * BT-115.
     */
    private float $duePayableAmount;
}
