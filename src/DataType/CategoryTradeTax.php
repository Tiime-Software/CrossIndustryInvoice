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
    private string $typeCode;

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
        $element = $document->createElement('ram:CategoryTradeTax');

        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode));
        $element->appendChild($document->createElement('ram:CategoryCode', $this->categoryCode->value));

        if ($this->rateApplicablePercent instanceof Percentage) {
            $element->appendChild($document->createElement('ram:RateApplicablePercent', (string) $this->rateApplicablePercent->getValueRounded()));
        }

        return $element;
    }
}
