<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\EN16931\DataType\DateCode2005;
use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\DataType\VatExoneration;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-23.
 */
class HeaderApplicableTradeTax
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
     * BT-8.
     */
    private ?DateCode2005 $dueDateTypeCode;

    /**
     * BT-119.
     */
    private ?Percentage $rateApplicablePercent;

    public function __construct(float $calculatedAmount, float $basisAmount, VatCategory $categoryCode)
    {
        $this->calculatedAmount      = new Amount($calculatedAmount);
        $this->basisAmount           = new Amount($basisAmount);
        $this->categoryCode          = $categoryCode;
        $this->typeCode              = 'VAT';
        $this->exemptionReason       = null;
        $this->exemptionReasonCode   = null;
        $this->dueDateTypeCode       = null;
        $this->rateApplicablePercent = null;
    }

    public function getCalculatedAmount(): float
    {
        return $this->calculatedAmount->getValueRounded();
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function getExemptionReason(): ?string
    {
        return $this->exemptionReason;
    }

    public function setExemptionReason(?string $exemptionReason): static
    {
        $this->exemptionReason = $exemptionReason;

        return $this;
    }

    public function getBasisAmount(): float
    {
        return $this->basisAmount->getValueRounded();
    }

    public function getCategoryCode(): VatCategory
    {
        return $this->categoryCode;
    }

    public function getExemptionReasonCode(): ?VatExoneration
    {
        return $this->exemptionReasonCode;
    }

    public function setExemptionReasonCode(?VatExoneration $exemptionReasonCode): static
    {
        $this->exemptionReasonCode = $exemptionReasonCode;

        return $this;
    }

    public function getDueDateTypeCode(): ?DateCode2005
    {
        return $this->dueDateTypeCode;
    }

    public function setDueDateTypeCode(?DateCode2005 $dueDateTypeCode): static
    {
        $this->dueDateTypeCode = $dueDateTypeCode;

        return $this;
    }

    public function getRateApplicablePercent(): ?float
    {
        return $this->rateApplicablePercent?->getValueRounded();
    }

    public function setRateApplicablePercent(?Percentage $rateApplicablePercent): static
    {
        $this->rateApplicablePercent = $rateApplicablePercent;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ApplicableTradeTax');

        $element->appendChild($document->createElement('ram:CalculatedAmount', (string) $this->calculatedAmount->getValueRounded()));
        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode));

        if (\is_string($this->exemptionReason)) {
            $element->appendChild($document->createElement('ram:ExemptionReason', $this->exemptionReason));
        }

        $element->appendChild($document->createElement('ram:BasisAmount', (string) $this->basisAmount->getValueRounded()));
        $element->appendChild($document->createElement('ram:CategoryCode', $this->categoryCode->value));

        if ($this->exemptionReasonCode instanceof VatExoneration) {
            $element->appendChild($document->createElement('ram:ExemptionReasonCode', $this->exemptionReasonCode->value));
        }

        if ($this->dueDateTypeCode instanceof DateCode2005) {
            $element->appendChild($document->createElement('ram:DueDateTypeCode', $this->dueDateTypeCode->value));
        }

        if ($this->rateApplicablePercent instanceof Percentage) {
            $element->appendChild($document->createElement('ram:RateApplicablePercent', (string) $this->rateApplicablePercent->getValueRounded()));
        }

        return $element;
    }
}
