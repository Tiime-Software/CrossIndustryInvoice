<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;

use Tiime\CrossIndustryInvoice\EN16931\TaxPointDate;
use Tiime\EN16931\DataType\DateCode2005;
use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\DataType\VatExoneration;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-23.
 */
class ApplicableTradeTax
{
    /**
     * BT-117.
     */
    private Amount $calculatedAmount;

    /**
     * BT-118-0.
     */
    private string $typeCode;

    /**
     * BT-120.
     */
    private ?string $exemptionReason;

    /**
     * BT-116.
     */
    private Amount $basisAmount;

    /**
     * BT-118.
     */
    private VatCategory $categoryCode;

    /**
     * BT-121.
     */
    private ?VatExoneration $exemptionReasonCode;

    /**
     * BT-7-00.
     */
    private ?TaxPointDate $taxPointDate;

    /**
     * BT-8.
     */
    private ?DateCode2005 $dueDateTypeCode;

    /**
     * BT-119.
     */
    private ?Percentage $rateApplicablePercent;

    public function __construct(Amount $calculatedAmount, Amount $basisAmount, VatCategory $categoryCode)
    {
        $this->calculatedAmount      = $calculatedAmount;
        $this->basisAmount           = $basisAmount;
        $this->categoryCode          = $categoryCode;
        $this->typeCode              = 'VAT';
        $this->exemptionReason       = null;
        $this->exemptionReasonCode   = null;
        $this->taxPointDate          = null;
        $this->dueDateTypeCode       = null;
        $this->rateApplicablePercent = null;
    }

    public function getCalculatedAmount(): Amount
    {
        return $this->calculatedAmount;
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function getExemptionReason(): ?string
    {
        return $this->exemptionReason;
    }

    public function setExemptionReason(?string $exemptionReason): void
    {
        $this->exemptionReason = $exemptionReason;
    }

    public function getBasisAmount(): Amount
    {
        return $this->basisAmount;
    }

    public function getCategoryCode(): VatCategory
    {
        return $this->categoryCode;
    }

    public function getExemptionReasonCode(): ?VatExoneration
    {
        return $this->exemptionReasonCode;
    }

    public function setExemptionReasonCode(?VatExoneration $exemptionReasonCode): void
    {
        $this->exemptionReasonCode = $exemptionReasonCode;
    }

    public function getTaxPointDate(): ?TaxPointDate
    {
        return $this->taxPointDate;
    }

    public function setTaxPointDate(?TaxPointDate $taxPointDate): void
    {
        $this->taxPointDate = $taxPointDate;
    }

    public function getDueDateTypeCode(): ?DateCode2005
    {
        return $this->dueDateTypeCode;
    }

    public function setDueDateTypeCode(?DateCode2005 $dueDateTypeCode): void
    {
        $this->dueDateTypeCode = $dueDateTypeCode;
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
