<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;

use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BT-102-00.
 */
class ChargeCategoryTradeTax
{
    /**
     * BT-102-0.
     */
    private string $typeCode;

    /**
     * BT-102.
     */
    private VatCategory $categoryCode;

    /**
     * BT-103.
     */
    private ?Percentage $rateApplicablePercent;

    public function __construct(VatCategory $categoryCode)
    {
        $this->categoryCode          = $categoryCode;
        $this->typeCode              = 'VAT';
        $this->rateApplicablePercent = null;
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function getCategoryCode(): VatCategory
    {
        return $this->categoryCode;
    }

    public function getRateApplicablePercent(): ?Percentage
    {
        return $this->rateApplicablePercent;
    }

    public function setRateApplicablePercent(?Percentage $rateApplicablePercent): void
    {
        $this->rateApplicablePercent = $rateApplicablePercent;
    }
}
