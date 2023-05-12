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
    protected const XML_NODE = 'ram:ApplicableTradeTax';

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

    public function getRateApplicablePercent(): ?float
    {
        return $this->rateApplicablePercent?->getValueRounded();
    }

    public function setRateApplicablePercent(?float $rateApplicablePercent): static
    {
        $this->rateApplicablePercent = \is_float($rateApplicablePercent) ? new Percentage($rateApplicablePercent) : null;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode));
        $element->appendChild($document->createElement('ram:CategoryCode', $this->categoryCode->value));

        if ($this->rateApplicablePercent instanceof Percentage) {
            $element->appendChild($document->createElement('ram:RateApplicablePercent', (string) $this->rateApplicablePercent->getValueRounded()));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $applicableTradeTaxElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableTradeTaxElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableTradeTaxElement */
        $applicableTradeTaxElement = $applicableTradeTaxElements->item(0);

        $typeCodeElements              = $xpath->query('.//ram:TypeCode', $applicableTradeTaxElement);
        $categoryCodeElements          = $xpath->query('.//ram:CategoryCode', $applicableTradeTaxElement);
        $rateApplicablePercentElements = $xpath->query('.//ram:RateApplicablePercent', $applicableTradeTaxElement);

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
