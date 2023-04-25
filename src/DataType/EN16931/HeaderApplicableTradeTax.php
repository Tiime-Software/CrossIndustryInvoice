<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\TaxPointDate;
use Tiime\EN16931\DataType\VatCategory;

/**
 * BG-23.
 */
class HeaderApplicableTradeTax extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\HeaderApplicableTradeTax
{
    /**
     * BT-7-00.
     */
    private ?TaxPointDate $taxPointDate;

    public function __construct(float $calculatedAmount, float $basisAmount, VatCategory $categoryCode)
    {
        parent::__construct($calculatedAmount, $basisAmount, $categoryCode);
        $this->taxPointDate = null;
    }

    public function getTaxPointDate(): ?TaxPointDate
    {
        return $this->taxPointDate;
    }

    public function setTaxPointDate(?TaxPointDate $taxPointDate): static
    {
        $this->taxPointDate = $taxPointDate;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:ApplicableTradeTax');

        $currentNode->appendChild($document->createElement('ram:CalculatedAmount', (string) $this->getCalculatedAmount()));

        $currentNode->appendChild($document->createElement('ram:TypeCode', $this->getTypeCode()));

        if (null !== $this->getExemptionReason()) {
            $currentNode->appendChild($document->createElement('ram:ExemptionReason', $this->getExemptionReason()));
        }

        $currentNode->appendChild($document->createElement('ram:BasisAmount', (string) $this->getBasisAmount()));

        $currentNode->appendChild($document->createElement('ram:CategoryCode', $this->getCategoryCode()->value));

        if (null !== $this->getExemptionReasonCode()) {
            $currentNode->appendChild($document->createElement('ram:ExemptionReasonCode', $this->getExemptionReasonCode()->value));
        }

        if (null !== $this->taxPointDate) {
            $currentNode->appendChild($this->taxPointDate->toXML($document));
        }

        if (null !== $this->getDueDateTypeCode()) {
            $currentNode->appendChild($document->createElement('ram:DueDateTypeCode', $this->getDueDateTypeCode()->value));
        }

        if (null !== $this->getRateApplicablePercent()) {
            $currentNode->appendChild($document->createElement('ram:RateApplicablePercent', (string) $this->getRateApplicablePercent()));
        }

        return $currentNode;
    }
}
