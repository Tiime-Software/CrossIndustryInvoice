<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\BusinessTermsGroup\DocumentLevelAllowance;
use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;
use Tiime\EN16931\SemanticDataType\Percentage;

/**
 * BG-20.
 */
class SpecifiedTradeAllowance
{
    protected const XML_NODE = 'ram:SpecifiedTradeAllowanceCharge';

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
    private ?AllowanceReasonCode $reasonCode;

    /**
     * BT-97.
     */
    private ?string $reason;

    /**
     * BT-95-00.
     */
    private CategoryTradeTax $allowanceCategoryTradeTax;

    public function __construct(float $actualAmount, CategoryTradeTax $allowanceCategoryTradeTax)
    {
        $this->allowanceChargeIndicator  = new AllowanceIndicator();
        $this->actualAmount              = new Amount($actualAmount);
        $this->allowanceCategoryTradeTax = $allowanceCategoryTradeTax;
        $this->calculationPercent        = null;
        $this->basisAmount               = null;
        $this->reasonCode                = null;
        $this->reason                    = null;
    }

    public function getAllowanceChargeIndicator(): AllowanceIndicator
    {
        return $this->allowanceChargeIndicator;
    }

    public function getActualAmount(): float
    {
        return $this->actualAmount->getValueRounded();
    }

    public function getAllowanceCategoryTradeTax(): CategoryTradeTax
    {
        return $this->allowanceCategoryTradeTax;
    }

    public function getCalculationPercent(): ?float
    {
        return $this->calculationPercent?->getValueRounded();
    }

    public function setCalculationPercent(?float $calculationPercent): static
    {
        $this->calculationPercent = \is_float($calculationPercent) ? new Percentage($calculationPercent) : null;

        return $this;
    }

    public function getBasisAmount(): ?float
    {
        return $this->basisAmount?->getValueRounded();
    }

    public function setBasisAmount(?float $basisAmount): static
    {
        $this->basisAmount = \is_float($basisAmount) ? new Amount($basisAmount) : null;

        return $this;
    }

    public function getReasonCode(): ?AllowanceReasonCode
    {
        return $this->reasonCode;
    }

    public function setReasonCode(?AllowanceReasonCode $reasonCode): static
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
            $currentNode->appendChild($document->createElement('ram:CalculationPercent', (string) $this->calculationPercent->getValueRounded()));
        }

        if ($this->basisAmount instanceof Amount) {
            $currentNode->appendChild($document->createElement('ram:BasisAmount', (string) $this->basisAmount->getValueRounded()));
        }

        $currentNode->appendChild($document->createElement('ram:ActualAmount', (string) $this->actualAmount->getValueRounded()));

        if ($this->reasonCode instanceof AllowanceReasonCode) {
            $currentNode->appendChild($document->createElement('ram:ReasonCode', $this->reasonCode->value));
        }

        if (\is_string($this->reason)) {
            $currentNode->appendChild($document->createElement('ram:Reason', $this->reason));
        }

        $currentNode->appendChild($this->allowanceCategoryTradeTax->toXML($document));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        $specifiedTradeAllowanceFalseIndicatorElements = $xpath->query(sprintf('.//%s/ram:ChargeIndicator/udt:Indicator[text() = \'false\']', self::XML_NODE), $currentElement);

        if (0 === $specifiedTradeAllowanceFalseIndicatorElements->count()) {
            return [];
        }

        $specifiedTradeAllowanceElements = [];

        foreach ($specifiedTradeAllowanceFalseIndicatorElements as $specifiedTradeAllowanceFalseIndicatorElement) {
            $specifiedTradeAllowanceElement = $xpath->query('.//../..', $specifiedTradeAllowanceFalseIndicatorElement);

            $specifiedTradeAllowanceElements[] = $specifiedTradeAllowanceElement->item(0);
        }

        $specifiedTradeAllowances = [];

        foreach ($specifiedTradeAllowanceElements as $specifiedTradeAllowanceElement) {
            $calculationPercentageElements = $xpath->query('.//ram:CalculationPercent', $specifiedTradeAllowanceElement);
            $basisAmountElements           = $xpath->query('.//ram:BasisAmount', $specifiedTradeAllowanceElement);
            $actualAmountElements          = $xpath->query('.//ram:ActualAmount', $specifiedTradeAllowanceElement);
            $reasonCodeElements            = $xpath->query('.//ram:ReasonCode', $specifiedTradeAllowanceElement);
            $reasonElements                = $xpath->query('.//ram:Reason', $specifiedTradeAllowanceElement);

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

            $specifiedTradeAllowance = new self((float) $actualAmount, $categoryTradeTax);

            if (1 === $calculationPercentageElements->count()) {
                $specifiedTradeAllowance->setCalculationPercent((float) $calculationPercentageElements->item(0)->nodeValue);
            }

            if (1 === $basisAmountElements->count()) {
                $specifiedTradeAllowance->setBasisAmount((float) $basisAmountElements->item(0)->nodeValue);
            }

            if (1 === $reasonCodeElements->count()) {
                $reasonCode = AllowanceReasonCode::tryFrom($reasonCodeElements->item(0)->nodeValue);

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

    public static function fromEN16931(DocumentLevelAllowance $allowance): static
    {
        $specifiedTradeAllowance = new self(
            $allowance->getAmount(),
            (new CategoryTradeTax($allowance->getVatCategoryCode()))->setRateApplicablePercent($allowance->getVatRate())
        );

        $specifiedTradeAllowance->setCalculationPercent($allowance->getPercentage())
            ->setBasisAmount($allowance->getBaseAmount())
            ->setReasonCode($allowance->getReasonCode())
            ->setReason($allowance->getReason());

        return $specifiedTradeAllowance;
    }
}
