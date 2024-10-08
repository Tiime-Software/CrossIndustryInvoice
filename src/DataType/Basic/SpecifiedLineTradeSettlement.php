<?php

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;

/**
 * BG-30-00.
 */
class SpecifiedLineTradeSettlement
{
    protected const string XML_NODE = 'ram:SpecifiedLineTradeSettlement';

    /**
     * BG-26.
     */
    protected ?BillingSpecifiedPeriod $billingSpecifiedPeriod;

    /**
     * BG-27.
     *
     * @var array<int, LineSpecifiedTradeAllowance>
     */
    protected array $specifiedTradeAllowances;

    /**
     * BG-28.
     *
     * @var array<int, LineSpecifiedTradeCharge>
     */
    protected array $specifiedTradeCharges;

    /**
     * @param ApplicableTradeTax                            $applicableTradeTax                            - BG-30
     * @param SpecifiedTradeSettlementLineMonetarySummation $specifiedTradeSettlementLineMonetarySummation - BT-131-00
     */
    public function __construct(
        protected ApplicableTradeTax $applicableTradeTax,
        protected SpecifiedTradeSettlementLineMonetarySummation $specifiedTradeSettlementLineMonetarySummation,
    ) {
        $this->specifiedTradeAllowances = [];
        $this->specifiedTradeCharges    = [];
        $this->billingSpecifiedPeriod   = null;
    }

    public function getApplicableTradeTax(): ApplicableTradeTax
    {
        return $this->applicableTradeTax;
    }

    public function getBillingSpecifiedPeriod(): ?BillingSpecifiedPeriod
    {
        return $this->billingSpecifiedPeriod;
    }

    public function setBillingSpecifiedPeriod(?BillingSpecifiedPeriod $billingSpecifiedPeriod): static
    {
        $this->billingSpecifiedPeriod = $billingSpecifiedPeriod;

        return $this;
    }

    public function getSpecifiedTradeAllowances(): array
    {
        return $this->specifiedTradeAllowances;
    }

    public function setSpecifiedTradeAllowances(array $specifiedTradeAllowances): static
    {
        foreach ($specifiedTradeAllowances as $specifiedTradeAllowance) {
            if (!$specifiedTradeAllowance instanceof LineSpecifiedTradeAllowance) {
                throw new \TypeError();
            }
        }

        $this->specifiedTradeAllowances = $specifiedTradeAllowances;

        return $this;
    }

    public function getSpecifiedTradeCharges(): array
    {
        return $this->specifiedTradeCharges;
    }

    public function setSpecifiedTradeCharges(array $specifiedTradeCharges): static
    {
        foreach ($specifiedTradeCharges as $specifiedTradeCharge) {
            if (!$specifiedTradeCharge instanceof LineSpecifiedTradeCharge) {
                throw new \TypeError();
            }
        }

        $this->specifiedTradeCharges = $specifiedTradeCharges;

        return $this;
    }

    public function getSpecifiedTradeSettlementLineMonetarySummation(): SpecifiedTradeSettlementLineMonetarySummation
    {
        return $this->specifiedTradeSettlementLineMonetarySummation;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->applicableTradeTax->toXML($document));

        if ($this->billingSpecifiedPeriod instanceof BillingSpecifiedPeriod) {
            $billingSpecifiedPeriodXml = $this->billingSpecifiedPeriod->toXML($document);

            if ($billingSpecifiedPeriodXml instanceof \DOMElement) {
                $currentNode->appendChild($billingSpecifiedPeriodXml);
            }
        }

        foreach ($this->specifiedTradeAllowances as $specifiedTradeAllowance) {
            $currentNode->appendChild($specifiedTradeAllowance->toXML($document));
        }

        foreach ($this->specifiedTradeCharges as $specifiedTradeCharge) {
            $currentNode->appendChild($specifiedTradeCharge->toXML($document));
        }

        $currentNode->appendChild($this->specifiedTradeSettlementLineMonetarySummation->toXML($document));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $specifiedLineTradeSettlementElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $specifiedLineTradeSettlementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedLineTradeSettlementElement */
        $specifiedLineTradeSettlementElement = $specifiedLineTradeSettlementElements->item(0);

        $applicableTradeTax                            = ApplicableTradeTax::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $billingSpecifiedPeriod                        = BillingSpecifiedPeriod::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $specifiedTradeAllowances                      = LineSpecifiedTradeAllowance::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $specifiedTradeCharges                         = LineSpecifiedTradeCharge::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $specifiedTradeSettlementLineMonetarySummation = SpecifiedTradeSettlementLineMonetarySummation::fromXML($xpath, $specifiedLineTradeSettlementElement);

        $specifiedLineTradeSettlement = new self($applicableTradeTax, $specifiedTradeSettlementLineMonetarySummation);

        if ($billingSpecifiedPeriod instanceof BillingSpecifiedPeriod) {
            $specifiedLineTradeSettlement->setBillingSpecifiedPeriod($billingSpecifiedPeriod);
        }

        if (\count($specifiedTradeAllowances) > 0) {
            $specifiedLineTradeSettlement->setSpecifiedTradeAllowances($specifiedTradeAllowances);
        }

        if (\count($specifiedTradeCharges) > 0) {
            $specifiedLineTradeSettlement->setSpecifiedTradeCharges($specifiedTradeCharges);
        }

        return $specifiedLineTradeSettlement;
    }
}
