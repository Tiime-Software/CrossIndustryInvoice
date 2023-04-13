<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\ChargeReasonCode;

/**
 * BG-21.
 */
class SpecifiedTradeCharge
{
    /**
     * BG-21-0.
     */
    private ChargeIndicator $chargeIndicator;

    /**
     * BT-101.
     */
    private ?float $calculationPercent;

    /**
     * BT-100.
     */
    private ?float $basisAmount;

    /**
     * BT-99.
     */
    private float $actualAmount;

    /**
     * BT-105.
     */
    private ?ChargeReasonCode $reasonCode;

    /**
     * BT-104.
     */
    private ?string $reason;

    /**
     * BT-102-00.
     */
    private CategoryTradeTax $categoryTradeTax;
}
