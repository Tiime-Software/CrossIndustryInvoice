<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\DateCode2005;
use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\DataType\VatExoneration;

/**
 * BG-23.
 */
class ApplicableTradeTax
{
    /**
     * BT-117.
     */
    private float $calculatedAmount;

    /**
     * BT-118-0.
     */
    private string $typeCode = 'VAT';

    /**
     * BT-120.
     */
    private ?string $exemptionReason;

    /**
     * BT-116.
     */
    private float $basisAmount;

    /**
     * BT-118.
     */
    private VatCategory $categoryCode;

    /**
     * BT-121.
     */
    private ?VatExoneration $exemptionReasonCode;

    /**
     * BT-8.
     */
    private ?DateCode2005 $dueDateTypeCode;

    /**
     * BT-119.
     */
    private ?float $rateApplicablePercent;
}
