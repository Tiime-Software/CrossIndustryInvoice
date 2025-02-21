<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\Codelist\AllowanceReasonCodeUNTDID5189;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-20.
 */
class SpecifiedTradeAllowance
{
    protected const string XML_NODE = 'ram:SpecifiedTradeAllowanceCharge';

    /**
     * BG-20-0.
     */
    private AllowanceIndicator $allowanceChargeIndicator;

    /**
     * BT-94.
     */
    private ?Percentage $calculationPercent;

    /**
     * BT-93.
     */
    private ?Amount $basisAmount;

    /**
     * BT-92.
     */
    private Amount $actualAmount;

    /**
     * BT-98.
     */
    private ?AllowanceReasonCodeUNTDID5189 $reasonCode;

    /**
     * BT-97.
     */
    private ?string $reason;

    /**
     * @param CategoryTradeTax $allowanceCategoryTradeTax - BT-95-00
     */
    public function __construct(
        float $actualAmount,
        private readonly CategoryTradeTax $allowanceCategoryTradeTax,
    ) {
        $this->allowanceChargeIndicator = new AllowanceIndicator();
        $this->actualAmount             = new Amount($actualAmount);
        $this->calculationPercent       = null;
        $this->basisAmount              = null;
        $this->reasonCode               = null;
        $this->reason                   = null;
    }

    public function getAllowanceChargeIndicator(): AllowanceIndicator
    {
        return $this->allowanceChargeIndicator;
    }

    public function getActualAmount(): Amount
    {
        return $this->actualAmount;
    }

    public function getAllowanceCategoryTradeTax(): CategoryTradeTax
    {
        return $this->allowanceCategoryTradeTax;
    }

    public function getCalculationPercent(): ?Percentage
    {
        return $this->calculationPercent;
    }

    public function setCalculationPercent(?float $calculationPercent): static
    {
        $this->calculationPercent = \is_float($calculationPercent) ? new Percentage($calculationPercent) : null;

        return $this;
    }

    public function getBasisAmount(): ?Amount
    {
        return $this->basisAmount;
    }

    public function setBasisAmount(?float $basisAmount): static
    {
        $this->basisAmount = \is_float($basisAmount) ? new Amount($basisAmount) : null;

        return $this;
    }

    public function getReasonCode(): ?AllowanceReasonCodeUNTDID5189
    {
        return $this->reasonCode;
    }

    public function setReasonCode(?AllowanceReasonCodeUNTDID5189 $reasonCode): static
    {
        $this->reasonCode = $reasonCode;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->allowanceChargeIndicator->toXML($document));

        if ($this->calculationPercent instanceof Percentage) {
            $currentNode->appendChild($document->createElement('ram:CalculationPercent', $this->calculationPercent->getFormattedValueRounded()));
        }

        if ($this->basisAmount instanceof Amount) {
            $currentNode->appendChild($document->createElement('ram:BasisAmount', $this->basisAmount->getFormattedValueRounded()));
        }

        $currentNode->appendChild($document->createElement('ram:ActualAmount', $this->actualAmount->getFormattedValueRounded()));

        if ($this->reasonCode instanceof AllowanceReasonCodeUNTDID5189) {
            $currentNode->appendChild($document->createElement('ram:ReasonCode', $this->reasonCode->value));
        }

        if (\is_string($this->reason)) {
            $currentNode->appendChild($document->createElement('ram:Reason', $this->reason));
        }

        $currentNode->appendChild($this->allowanceCategoryTradeTax->toXML($document));

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): array
    {
        $specifiedTradeAllowanceElements = $xpath->query(\sprintf('./%s[ram:ChargeIndicator/udt:Indicator[text() = \'false\']]', self::XML_NODE), $currentElement);

        if (0 === $specifiedTradeAllowanceElements->count()) {
            return [];
        }

        $specifiedTradeAllowances = [];

        /** @var \DOMElement $specifiedTradeAllowanceElement */
        foreach ($specifiedTradeAllowanceElements as $specifiedTradeAllowanceElement) {
            $calculationPercentageElements = $xpath->query('./ram:CalculationPercent', $specifiedTradeAllowanceElement);
            $basisAmountElements           = $xpath->query('./ram:BasisAmount', $specifiedTradeAllowanceElement);
            $actualAmountElements          = $xpath->query('./ram:ActualAmount', $specifiedTradeAllowanceElement);
            $reasonCodeElements            = $xpath->query('./ram:ReasonCode', $specifiedTradeAllowanceElement);
            $reasonElements                = $xpath->query('./ram:Reason', $specifiedTradeAllowanceElement);

            if ($calculationPercentageElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            if ($basisAmountElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            if (1 !== $actualAmountElements->count()) {
                throw new \Exception('Malformed');
            }

            if ($reasonCodeElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            if ($reasonElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            $actualAmount = $actualAmountElements->item(0)->nodeValue;

            $categoryTradeTax = CategoryTradeTax::fromXML($xpath, $specifiedTradeAllowanceElement);

            // Look if node is well constructed, already created in the constructor
            AllowanceIndicator::fromXML($xpath, $specifiedTradeAllowanceElement);

            $specifiedTradeAllowance = new self((float) $actualAmount, $categoryTradeTax);

            if (1 === $calculationPercentageElements->count()) {
                $specifiedTradeAllowance->setCalculationPercent((float) $calculationPercentageElements->item(0)->nodeValue);
            }

            if (1 === $basisAmountElements->count()) {
                $specifiedTradeAllowance->setBasisAmount((float) $basisAmountElements->item(0)->nodeValue);
            }

            if (1 === $reasonCodeElements->count()) {
                $reasonCode = AllowanceReasonCodeUNTDID5189::tryFrom($reasonCodeElements->item(0)->nodeValue);

                if (null === $reasonCode) {
                    throw new \Exception('Wrong ReasonCode');
                }

                $specifiedTradeAllowance->setReasonCode($reasonCode);
            }

            if (1 === $reasonElements->count()) {
                $specifiedTradeAllowance->setReason($reasonElements->item(0)->nodeValue);
            }

            $specifiedTradeAllowances[] = $specifiedTradeAllowance;
        }

        return $specifiedTradeAllowances;
    }
}
