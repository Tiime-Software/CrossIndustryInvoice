<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-30.
 */
class ApplicableTradeTax
{
    /**
     * BT-151-0.
     */
    private string $typeCode;

    /**
     * BT-151.
     */
    private VatCategory $categoryCode;

    /**
     * BT-152.
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

    public function setRateApplicablePercent(?Percentage $rateApplicablePercent): static
    {
        $this->rateApplicablePercent = $rateApplicablePercent;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ApplicableTradeTax');

        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode));
        $element->appendChild($document->createElement('ram:CategoryCode', $this->categoryCode->value));

        if ($this->rateApplicablePercent instanceof Percentage) {
            $element->appendChild($document->createElement('ram:RateApplicablePercent', (string) $this->rateApplicablePercent->getValueRounded()));
        }

        return $element;
    }
}
