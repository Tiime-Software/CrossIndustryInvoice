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
    protected const string XML_NODE = 'ram:ApplicableTradeTax';

    /**
     * BT-151-0.
     */
    private string $typeCode;

    /**
     * BT-152.
     */
    private ?Percentage $rateApplicablePercent;

    /**
     * @param VatCategory $categoryCode - BT-151
     */
    public function __construct(
        private VatCategory $categoryCode,
    ) {
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

    public function setRateApplicablePercent(?float $rateApplicablePercent): static
    {
        $this->rateApplicablePercent = \is_float($rateApplicablePercent) ? new Percentage($rateApplicablePercent) : null;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:TypeCode', $this->typeCode));
        $currentNode->appendChild($document->createElement('ram:CategoryCode', $this->categoryCode->value));

        if ($this->rateApplicablePercent instanceof Percentage) {
            $currentNode->appendChild($document->createElement('ram:RateApplicablePercent', $this->rateApplicablePercent->getFormattedValueRounded()));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $applicableTradeTaxElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableTradeTaxElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableTradeTaxElement */
        $applicableTradeTaxElement = $applicableTradeTaxElements->item(0);

        $typeCodeElements              = $xpath->query('./ram:TypeCode', $applicableTradeTaxElement);
        $categoryCodeElements          = $xpath->query('./ram:CategoryCode', $applicableTradeTaxElement);
        $rateApplicablePercentElements = $xpath->query('./ram:RateApplicablePercent', $applicableTradeTaxElement);

        if (1 !== $typeCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $categoryCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($rateApplicablePercentElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $categoryCode = VatCategory::tryFrom($categoryCodeElements->item(0)->nodeValue);

        if ('VAT' !== $typeCodeElements->item(0)->nodeValue) {
            throw new \Exception('Wrong TypeCode');
        }

        if (!$categoryCode instanceof VatCategory) {
            throw new \Exception('Wrong CategoryCode');
        }

        $applicableTradeTax = new self($categoryCode);

        if (1 === $rateApplicablePercentElements->count()) {
            $applicableTradeTax->setRateApplicablePercent((float) $rateApplicablePercentElements->item(0)->nodeValue);
        }

        return $applicableTradeTax;
    }
}
