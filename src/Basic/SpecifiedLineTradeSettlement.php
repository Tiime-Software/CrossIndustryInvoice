<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\Basic\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\Basic\LineSpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\Basic\LineSpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;

/**
 * BG-30-00.
 */
class SpecifiedLineTradeSettlement
{
    protected const XML_NODE = 'ram:SpecifiedLineTradeSettlement';

    /**
     * BG-30.
     */
    private ApplicableTradeTax $applicableTradeTax;

    /**
     * BG-26.
     */
    private ?BillingSpecifiedPeriod $billingSpecifiedPeriod;

    /**
     * BG-27.
     *
     * @var array<int, LineSpecifiedTradeAllowance>
     */
    private array $specifiedTradeAllowances;

    /**
     * BG-28.
     *
     * @var array<int, LineSpecifiedTradeCharge>
     */
    private array $specifiedTradeCharges;

    /**
     * BT-131-00.
     */
    private SpecifiedTradeSettlementLineMonetarySummation $specifiedTradeSettlementMonetarySummation;

    public function __construct(
        ApplicableTradeTax $applicableTradeTax,
        SpecifiedTradeSettlementLineMonetarySummation $specifiedTradeSettlementMonetarySummation
    ) {
        $this->applicableTradeTax                        = $applicableTradeTax;
        $this->specifiedTradeSettlementMonetarySummation = $specifiedTradeSettlementMonetarySummation;
        $this->specifiedTradeAllowances                  = [];
        $this->specifiedTradeCharges                     = [];
        $this->billingSpecifiedPeriod                    = null;
    }

    public function getApplicableTradeTax(): ApplicableTradeTax
    {
        return $this->applicableTradeTax;
    }

    public function getBillingSpecifiedPeriod(): ?BillingSpecifiedPeriod
    {
        return $this->billingSpecifiedPeriod;
    }

    public function setBillingSpecifiedPeriod(?BillingSpecifiedPeriod $billingSpecifiedPeriod): void
    {
        $this->billingSpecifiedPeriod = $billingSpecifiedPeriod;
    }

    public function getSpecifiedTradeAllowances(): array
    {
        return $this->specifiedTradeAllowances;
    }

    public function setSpecifiedTradeAllowances(array $specifiedTradeAllowances): static
    {
        $tmpSpecifiedTradeAllowances = [];

        foreach ($specifiedTradeAllowances as $specifiedTradeAllowance) {
            if (!$specifiedTradeAllowance instanceof LineSpecifiedTradeAllowance) {
                throw new \TypeError();
            }

            $tmpSpecifiedTradeAllowances[] = $specifiedTradeAllowance;
        }

        $this->specifiedTradeAllowances = $tmpSpecifiedTradeAllowances;

        return $this;
    }

    public function getSpecifiedTradeCharges(): array
    {
        return $this->specifiedTradeCharges;
    }

    public function setSpecifiedTradeCharges(array $specifiedTradeCharges): static
    {
        $tmpSpecifiedTradeCharges = [];

        foreach ($specifiedTradeCharges as $specifiedTradeCharge) {
            if (!$specifiedTradeCharge instanceof LineSpecifiedTradeCharge) {
                throw new \TypeError();
            }

            $tmpSpecifiedTradeCharges[] = $specifiedTradeCharge;
        }

        $this->specifiedTradeCharges = $tmpSpecifiedTradeCharges;

        return $this;
    }

    public function getSpecifiedTradeSettlementMonetarySummation(): SpecifiedTradeSettlementLineMonetarySummation
    {
        return $this->specifiedTradeSettlementMonetarySummation;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->applicableTradeTax->toXML($document));

        if ($this->billingSpecifiedPeriod instanceof BillingSpecifiedPeriod) {
            $currentNode->appendChild($this->billingSpecifiedPeriod->toXML($document));
        }

        foreach ($this->specifiedTradeAllowances as $specifiedTradeAllowance) {
            $currentNode->appendChild($specifiedTradeAllowance->toXML($document));
        }

        foreach ($this->specifiedTradeCharges as $specifiedTradeCharge) {
            $currentNode->appendChild($specifiedTradeCharge->toXML($document));
        }

        $this->specifiedTradeSettlementMonetarySummation->toXML($document);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $specifiedLineTradeSettlementElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $specifiedLineTradeSettlementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedLineTradeSettlementElement */
        $specifiedLineTradeSettlementElement = $specifiedLineTradeSettlementElements->item(0);

        $applicableTradeTax                        = ApplicableTradeTax::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $billingSpecifiedPeriod                    = BillingSpecifiedPeriod::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $specifiedTradeAllowances                  = LineSpecifiedTradeAllowance::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $specifiedTradeCharges                     = LineSpecifiedTradeCharge::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $specifiedTradeSettlementMonetarySummation = SpecifiedTradeSettlementLineMonetarySummation::fromXML($xpath, $specifiedLineTradeSettlementElement);

        $specifiedLineTradeSettlement = new static($applicableTradeTax, $specifiedTradeSettlementMonetarySummation);

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
