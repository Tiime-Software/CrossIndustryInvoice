<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Flux1;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-22.
 */
class SpecifiedTradeSettlementHeaderMonetarySummation
{
    protected const string XML_NODE = 'ram:SpecifiedTradeSettlementHeaderMonetarySummation';

    /**
     * BT-109.
     */
    protected Amount $taxBasisTotalAmount;

    /**
     * BT-110 & BT-110-0.
     */
    protected ?TaxTotalAmount $taxTotalAmount;

    public function __construct(float $taxBasisTotalAmount)
    {
        $this->taxBasisTotalAmount = new Amount($taxBasisTotalAmount);
        $this->taxTotalAmount      = null;
    }

    public function getTaxBasisTotalAmount(): Amount
    {
        return $this->taxBasisTotalAmount;
    }

    public function getTaxTotalAmount(): ?TaxTotalAmount
    {
        return $this->taxTotalAmount;
    }

    public function setTaxTotalAmount(?TaxTotalAmount $taxTotalAmount): static
    {
        $this->taxTotalAmount = $taxTotalAmount;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:TaxBasisTotalAmount', $this->taxBasisTotalAmount->getFormattedValueRounded()));

        if ($this->taxTotalAmount instanceof TaxTotalAmount) {
            $currentNode->appendChild($this->taxTotalAmount->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
    {
        $specifiedTradeSettlementHeaderMonetarySummationElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $specifiedTradeSettlementHeaderMonetarySummationElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedTradeSettlementHeaderMonetarySummationElement */
        $specifiedTradeSettlementHeaderMonetarySummationElement = $specifiedTradeSettlementHeaderMonetarySummationElements->item(0);

        $taxBasisTotalAmountElements = $xpath->query('./ram:TaxBasisTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);

        if (1 !== $taxBasisTotalAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        $taxBasisTotalAmount = $taxBasisTotalAmountElements->item(0)->nodeValue;

        $taxTotalAmountElements = $xpath->query('./ram:TaxTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);

        if ($taxTotalAmountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $specifiedTradeSettlementHeaderMonetarySummation = new self((float) $taxBasisTotalAmount);

        if (1 === $taxTotalAmountElements->count()) {
            /** @var \DOMElement $taxTotalAmountItem */
            $taxTotalAmountItem = $taxTotalAmountElements->item(0);

            $taxTotalAmount = TaxTotalAmount::fromXML($taxTotalAmountItem);

            $specifiedTradeSettlementHeaderMonetarySummation->setTaxTotalAmount($taxTotalAmount);
        }

        return $specifiedTradeSettlementHeaderMonetarySummation;
    }
}
