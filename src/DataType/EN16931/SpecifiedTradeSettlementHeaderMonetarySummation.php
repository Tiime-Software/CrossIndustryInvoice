<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-22.
 */
class SpecifiedTradeSettlementHeaderMonetarySummation extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\SpecifiedTradeSettlementHeaderMonetarySummation
{
    /**
     * BT-114.
     */
    private ?Amount $roundingAmount;

    public function __construct(
        float $taxBasisTotalAmount,
        float $lineTotalAmount,
        float $grandTotalAmount,
        float $duePayableAmount,
        TaxTotalAmount $taxTotalAmount = null,
    ) {
        parent::__construct($taxBasisTotalAmount, $lineTotalAmount, $grandTotalAmount, $duePayableAmount, $taxTotalAmount);

        $this->roundingAmount = null;
    }

    public function getRoundingAmount(): ?float
    {
        return $this->roundingAmount instanceof Amount ? $this->roundingAmount->getValueRounded() : null;
    }

    public function setRoundingAmount(?float $roundingAmount): void
    {
        $this->roundingAmount = \is_float($roundingAmount) ? new Amount($roundingAmount) : null;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:SpecifiedTradeSettlementHeaderMonetarySummation');

        $currentNode->appendChild($document->createElement('ram:LineTotalAmount', (string) $this->getLineTotalAmount()));

        if (null !== $this->getChargeTotalAmount()) {
            $currentNode->appendChild($document->createElement('ram:ChargeTotalAmount', (string) $this->getChargeTotalAmount()));
        }

        if (null !== $this->getAllowanceTotalAmount()) {
            $currentNode->appendChild($document->createElement('ram:AllowanceTotalAmount', (string) $this->getAllowanceTotalAmount()));
        }

        $currentNode->appendChild($document->createElement('ram:TaxBasisTotalAmount', (string) $this->getTaxBasisTotalAmount()));

        if (null !== $this->getTaxTotalAmount()) {
            $currentNode->appendChild($this->getTaxTotalAmount()->toXML($document));
        }

        if (null !== $this->getTaxTotalAmountCurrency()) {
            $currentNode->appendChild($this->getTaxTotalAmountCurrency()->toXML($document));
        }

        if (null !== $this->roundingAmount) {
            $currentNode->appendChild($document->createElement('ram:RoundingAmount', (string) $this->roundingAmount->getValueRounded()));
        }

        $currentNode->appendChild($document->createElement('ram:GrandTotalAmount', (string) $this->getGrandTotalAmount()));

        if (null !== $this->getTotalPrepaidAmount()) {
            $currentNode->appendChild($document->createElement('ram:TotalPrepaidAmount', (string) $this->getTotalPrepaidAmount()));
        }

        $currentNode->appendChild($document->createElement('ram:DuePayableAmount', (string) $this->getDuePayableAmount()));

        return $currentNode;
    }
}
