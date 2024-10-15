<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\EN16931\Codelist\CurrencyCodeISO4217;
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
        float $grandTotalAmount,
        float $duePayableAmount,
        float $lineTotalAmount,
    ) {
        parent::__construct($taxBasisTotalAmount, $grandTotalAmount, $duePayableAmount, $lineTotalAmount);

        $this->roundingAmount = null;
    }

    public function getRoundingAmount(): ?Amount
    {
        return $this->roundingAmount;
    }

    public function setRoundingAmount(?float $roundingAmount): static
    {
        $this->roundingAmount = \is_float($roundingAmount) ? new Amount($roundingAmount) : null;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:LineTotalAmount', $this->lineTotalAmount->getFormattedValueRounded()));

        if ($this->chargeTotalAmount instanceof Amount) {
            $currentNode->appendChild($document->createElement('ram:ChargeTotalAmount', $this->chargeTotalAmount->getFormattedValueRounded()));
        }

        if ($this->allowanceTotalAmount instanceof Amount) {
            $currentNode->appendChild($document->createElement('ram:AllowanceTotalAmount', $this->allowanceTotalAmount->getFormattedValueRounded()));
        }

        $currentNode->appendChild($document->createElement('ram:TaxBasisTotalAmount', $this->taxBasisTotalAmount->getFormattedValueRounded()));

        if ($this->taxTotalAmount instanceof TaxTotalAmount) {
            $currentNode->appendChild($this->taxTotalAmount->toXML($document));
        }

        if ($this->taxTotalAmountCurrency instanceof TaxTotalAmount) {
            $currentNode->appendChild($this->taxTotalAmountCurrency->toXML($document));
        }

        if ($this->roundingAmount instanceof Amount) {
            $currentNode->appendChild($document->createElement('ram:RoundingAmount', $this->roundingAmount->getFormattedValueRounded()));
        }

        $currentNode->appendChild($document->createElement('ram:GrandTotalAmount', $this->grandTotalAmount->getFormattedValueRounded()));

        if ($this->totalPrepaidAmount instanceof Amount) {
            $currentNode->appendChild($document->createElement('ram:TotalPrepaidAmount', $this->totalPrepaidAmount->getFormattedValueRounded()));
        }

        $currentNode->appendChild($document->createElement('ram:DuePayableAmount', $this->duePayableAmount->getFormattedValueRounded()));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $specifiedTradeSettlementHeaderMonetarySummationElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $specifiedTradeSettlementHeaderMonetarySummationElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedTradeSettlementHeaderMonetarySummationElement */
        $specifiedTradeSettlementHeaderMonetarySummationElement = $specifiedTradeSettlementHeaderMonetarySummationElements->item(0);

        $lineTotalAmountElements      = $xpath->query('./ram:LineTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);
        $chargeTotalAmountElements    = $xpath->query('./ram:ChargeTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);
        $allowanceTotalAmountElements = $xpath->query('./ram:AllowanceTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);
        $taxBasisTotalAmountElements  = $xpath->query('./ram:TaxBasisTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);
        $roundingAmountElements       = $xpath->query('./ram:RoundingAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);
        $grandTotalAmountElements     = $xpath->query('./ram:GrandTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);
        $totalPrepaidAmountElements   = $xpath->query('./ram:TotalPrepaidAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);
        $duePayableAmountElements     = $xpath->query('./ram:DuePayableAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);

        if (1 !== $lineTotalAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($chargeTotalAmountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($allowanceTotalAmountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $taxBasisTotalAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($roundingAmountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $grandTotalAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($totalPrepaidAmountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $duePayableAmountElements->count()) {
            throw new \Exception('Malformed');
        }

        $lineTotalAmount     = $lineTotalAmountElements->item(0)->nodeValue;
        $taxBasisTotalAmount = $taxBasisTotalAmountElements->item(0)->nodeValue;
        $grandTotalAmount    = $grandTotalAmountElements->item(0)->nodeValue;
        $duePayableAmount    = $duePayableAmountElements->item(0)->nodeValue;

        $specifiedTradeSettlementHeaderMonetarySummation = new self((float) $taxBasisTotalAmount, (float) $grandTotalAmount, (float) $duePayableAmount, (float) $lineTotalAmount);

        if (1 === $chargeTotalAmountElements->count()) {
            $specifiedTradeSettlementHeaderMonetarySummation->setChargeTotalAmount((float) $chargeTotalAmountElements->item(0)->nodeValue);
        }

        if (1 === $allowanceTotalAmountElements->count()) {
            $specifiedTradeSettlementHeaderMonetarySummation->setAllowanceTotalAmount((float) $allowanceTotalAmountElements->item(0)->nodeValue);
        }

        if (1 === $roundingAmountElements->count()) {
            $specifiedTradeSettlementHeaderMonetarySummation->setRoundingAmount((float) $roundingAmountElements->item(0)->nodeValue);
        }

        if (1 === $totalPrepaidAmountElements->count()) {
            $specifiedTradeSettlementHeaderMonetarySummation->setTotalPrepaidAmount((float) $totalPrepaidAmountElements->item(0)->nodeValue);
        }

        /** Checks BT-5/BT-6 for BT-110/BT-111 */
        $invoiceCurrencyCodeElements = $xpath->query('./ram:InvoiceCurrencyCode', $currentElement);
        $taxCurrencyCodeElements     = $xpath->query('./ram:TaxCurrencyCode', $currentElement);

        if (1 !== $invoiceCurrencyCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($taxCurrencyCodeElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $invoiceCurrencyCode = CurrencyCodeISO4217::tryFrom($invoiceCurrencyCodeElements->item(0)->nodeValue);

        if (null === $invoiceCurrencyCode) {
            throw new \Exception('Wrong InvoiceCurrencyCode');
        }

        $taxCurrencyCode = null;

        if (1 === $taxCurrencyCodeElements->count()) {
            $taxCurrencyCode = CurrencyCodeISO4217::tryFrom($taxCurrencyCodeElements->item(0)->nodeValue);

            if (null === $taxCurrencyCode) {
                throw new \Exception('Wrong TaxCurrencyCode');
            }
        }

        $taxTotalAmountElements = $xpath->query('./ram:TaxTotalAmount', $specifiedTradeSettlementHeaderMonetarySummationElement);

        if (null === $taxCurrencyCode || $invoiceCurrencyCode === $taxCurrencyCode) {
            /* Same currency code for BT-5 & BT-6, only fill BT-110, no need to fill BT-111 */
            /* Because we have one currency, one line maximum */
            if ($taxTotalAmountElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            if (1 === $taxTotalAmountElements->count()) {
                /** @var \DOMElement $taxTotalAmountItem */
                $taxTotalAmountItem = $taxTotalAmountElements->item(0);

                $taxTotalAmount = TaxTotalAmount::fromXML($taxTotalAmountItem);

                $specifiedTradeSettlementHeaderMonetarySummation->setTaxTotalAmount($taxTotalAmount);
            }
        } else {
            /* Not same currency code for BT-5 & BT-6, have to fill BT-110 & BT-111 */
            /* Because we have two currencies, two lines maximum */
            if ($taxTotalAmountElements->count() > 2) {
                throw new \Exception('Malformed');
            }

            /** @var \DOMElement $taxTotalAmountElement */
            foreach ($taxTotalAmountElements as $taxTotalAmountElement) {
                $taxTotalAmount = TaxTotalAmount::fromXML($taxTotalAmountElement);

                if ($taxTotalAmount->getCurrencyIdentifier() === $taxCurrencyCode) {
                    $specifiedTradeSettlementHeaderMonetarySummation->setTaxTotalAmountCurrency($taxTotalAmount);
                }

                if ($taxTotalAmount->getCurrencyIdentifier() === $invoiceCurrencyCode) {
                    $specifiedTradeSettlementHeaderMonetarySummation->setTaxTotalAmount($taxTotalAmount);
                }
            }
        }

        return $specifiedTradeSettlementHeaderMonetarySummation;
    }
}
