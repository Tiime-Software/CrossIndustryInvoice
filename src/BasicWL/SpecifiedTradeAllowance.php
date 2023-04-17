<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\AllowanceReasonCode;

class SpecifiedTradeAllowance
{
    /**
     * BG-20-0.
     */
    private ChargeIndicator $chargeIndicator;

    /**
     * BT-94.
     */
    private ?float $calculationPercent;

    /**
     * BT-93.
     */
    private ?float $basisAmount;

    /**
     * BT-92.
     */
    private float $actualAmount;

    /**
     * BT-98.
     */
    private ?AllowanceReasonCode $reasonCode;

    /**
     * BT-97.
     */
    private ?string $reason;

    /**
     * BT-95-00.
     */
    private CategoryTradeTax $categoryTradeTax;
}
