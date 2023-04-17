<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\VatCategory;

/**
 * BT-95-00.
 */
class CategoryTradeTax
{
    /**
     * BT-95-0.
     */
    private string $typeCode = 'VAT';

    /**
     * BT-95.
     */
    private VatCategory $categoryCode;

    /**
     * BT-96.
     */
    private ?float $rateApplicablePercent;
}
