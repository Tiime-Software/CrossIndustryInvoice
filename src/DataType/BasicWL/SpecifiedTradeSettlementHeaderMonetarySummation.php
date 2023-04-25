<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-22.
 */
class SpecifiedTradeSettlementHeaderMonetarySummation extends \Tiime\CrossIndustryInvoice\DataType\Minimum\SpecifiedTradeSettlementHeaderMonetarySummation
{
    /**
     * BT-106.
     */
    private Amount $lineTotalAmount;

    /**
     * BT-108.
     */
    private ?Amount $chargeTotalAmount;

    /**
     * BT-107.
     */
    private ?Amount $allowanceTotalAmount;

    /**
     * BT-111 & BT-111-0.
     */
    private ?TaxTotalAmount $taxTotalAmountCurrency;

    /**
     * BT-113.
     */
    private ?Amount $totalPrepaidAmount;

    public function __construct(
        float $taxBasisTotalAmount,
        float $lineTotalAmount,
        float $grandTotalAmount,
        float $duePayableAmount,
        TaxTotalAmount $taxTotalAmount = null,
    ) {
        parent::__construct($taxBasisTotalAmount, $grandTotalAmount, $duePayableAmount, $taxTotalAmount);

        $this->lineTotalAmount = new Amount($lineTotalAmount);

        $this->chargeTotalAmount      = null;
        $this->allowanceTotalAmount   = null;
        $this->taxTotalAmountCurrency = null;
        $this->totalPrepaidAmount     = null;
    }

    public function getLineTotalAmount(): float
    {
        return $this->lineTotalAmount->getValueRounded();
    }

    public function getChargeTotalAmount(): ?float
    {
        return $this->chargeTotalAmount instanceof Amount ? $this->chargeTotalAmount->getValueRounded() : null;
    }

    public function setChargeTotalAmount(?float $chargeTotalAmount = null): static
    {
        $this->chargeTotalAmount = \is_float($chargeTotalAmount) ? new Amount($chargeTotalAmount) : null;

        return $this;
    }

    public function getAllowanceTotalAmount(): ?float
    {
        return $this->allowanceTotalAmount instanceof Amount ? $this->allowanceTotalAmount->getValueRounded() : null;
    }

    public function setAllowanceTotalAmount(?float $allowanceTotalAmount): static
    {
        $this->allowanceTotalAmount = \is_float($allowanceTotalAmount) ? new Amount($allowanceTotalAmount) : null;

        return $this;
    }

    public function getTaxTotalAmountCurrency(): ?TaxTotalAmount
    {
        return $this->taxTotalAmountCurrency;
    }

    public function setTaxTotalAmountCurrency(?TaxTotalAmount $taxTotalAmountCurrency): static
    {
        $this->taxTotalAmountCurrency = $taxTotalAmountCurrency;

        return $this;
    }

    public function getTotalPrepaidAmount(): ?float
    {
        return $this->totalPrepaidAmount instanceof Amount ? $this->totalPrepaidAmount->getValueRounded() : null;
    }

    public function setTotalPrepaidAmount(?float $totalPrepaidAmount): static
    {
        $this->totalPrepaidAmount = \is_float($totalPrepaidAmount) ? new Amount($totalPrepaidAmount) : null;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:SpecifiedTradeSettlementHeaderMonetarySummation');

        $currentNode->appendChild($document->createElement('ram:LineTotalAmount', (string) $this->lineTotalAmount->getValueRounded()));

        if (null !== $this->chargeTotalAmount) {
            $currentNode->appendChild($document->createElement('ram:ChargeTotalAmount', (string) $this->chargeTotalAmount->getValueRounded()));
        }

        if (null !== $this->allowanceTotalAmount) {
            $currentNode->appendChild($document->createElement('ram:AllowanceTotalAmount', (string) $this->allowanceTotalAmount->getValueRounded()));
        }

        $currentNode->appendChild($document->createElement('ram:TaxBasisTotalAmount', (string) $this->getTaxBasisTotalAmount()));

        if (null !== $this->getTaxTotalAmount()) {
            $currentNode->appendChild($this->getTaxTotalAmount()->toXML($document));
        }

        if (null !== $this->taxTotalAmountCurrency) {
            $currentNode->appendChild($this->taxTotalAmountCurrency->toXML($document));
        }

        $currentNode->appendChild($document->createElement('ram:GrandTotalAmount', (string) $this->getGrandTotalAmount()));

        if (null !== $this->totalPrepaidAmount) {
            $currentNode->appendChild($document->createElement('ram:TotalPrepaidAmount', (string) $this->totalPrepaidAmount->getValueRounded()));
        }

        $currentNode->appendChild($document->createElement('ram:DuePayableAmount', (string) $this->getDuePayableAmount()));

        return $currentNode;
    }
}
