<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\Codelist\DutyTaxFeeCategoryCodeUNTDID5305;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BT-95-00.
 */
class CategoryTradeTax
{
    protected const string XML_NODE = 'ram:CategoryTradeTax';

    /**
     * BT-95-0.
     */
    private string $typeCode;

    /**
     * BT-96.
     */
    private ?Percentage $rateApplicablePercent;

    /**
     * @param DutyTaxFeeCategoryCodeUNTDID5305 $categoryCode - BT-95
     */
    public function __construct(
        private readonly DutyTaxFeeCategoryCodeUNTDID5305 $categoryCode,
    ) {
        $this->typeCode              = 'VAT';
        $this->rateApplicablePercent = null;
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function getCategoryCode(): DutyTaxFeeCategoryCodeUNTDID5305
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
        $categoryTradeTaxElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $categoryTradeTaxElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $categoryTradeTaxElement */
        $categoryTradeTaxElement = $categoryTradeTaxElements->item(0);

        $typeCodeElements              = $xpath->query('./ram:TypeCode', $categoryTradeTaxElement);
        $categoryCodeElements          = $xpath->query('./ram:CategoryCode', $categoryTradeTaxElement);
        $rateApplicablePercentElements = $xpath->query('./ram:RateApplicablePercent', $categoryTradeTaxElement);

        if (1 !== $typeCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $categoryCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($rateApplicablePercentElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $categoryCode = DutyTaxFeeCategoryCodeUNTDID5305::tryFrom($categoryCodeElements->item(0)->nodeValue);

        if (null === $categoryCode) {
            throw new \Exception('Wrong CategoryCode');
        }

        if ('VAT' !== $typeCodeElements->item(0)->nodeValue) {
            throw new \Exception('Wrong TypeCode');
        }

        $categoryTradeTax = new self($categoryCode);

        if (1 === $rateApplicablePercentElements->count()) {
            $categoryTradeTax->setRateApplicablePercent(new Percentage((float) $rateApplicablePercentElements->item(0)->nodeValue));
        }

        return $categoryTradeTax;
    }
}
