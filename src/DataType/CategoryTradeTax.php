<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\SemanticDataType\Percentage;

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
