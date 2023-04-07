<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-22
 */
class SpecifiedTradeSettlementHeaderMonetarySummation
{
    /**
     * BT-109
     */
    private Amount $taxBasisTotalAmount;

    /**
     * BT-110
     *
     * TODO : error in spec ?
     * If there is only one possible value for $taxTotalAmount, made the choice to keep the two fields (BT-110 et BT-110-0) in this entity with condition on constructor
     *
     * In Factur-X-1.0.06-2022-03-01-FINAL-FR\3. FACTUR-X 1.0.06 - 2022 03 01 - FR VF.xlsx
     * Line 41, column AM : 0..2
     *
     * In Factur-X-1.0.06-2022-03-01-FINAL-FR\4. FACTUR-X_1.0.06_XSD_SCHEMATRON - 2022 03 01\0. Factur-X_1.0.06_MINIMUM_XSD\Schematron\FACTUR-X_MINIMUM.sch
     * Line 1516 : <assert test="count(ram:TaxTotalAmount)&lt;=1">Element 'ram:TaxTotalAmount' may occur at maximum 1 times.</assert>
     */
    private ?Amount $taxTotalAmount;

    /**
     * BT-110-0
     *
     * TODO : (Annexe 7 - Règle de gestion V1.4) - ISO 4217 ??
     */
    private ?string $currencyID;

    /**
     * BT-112
     */
    private Amount $grandTotalAmount;

    /**
     * BT-115
     */
    private Amount $amountDueForPayment;

    public function __construct(
        float $taxBasisTotalAmount,
        float $grandTotalAmount,
        float $amountDueForPayment,
        ?float $taxTotalAmount = null,
        ?string $currencyID = null
    ) {
        if (null === $taxTotalAmount && null !== $currencyID) {
            throw new \Exception('Not possible to set currency for TaxTotalAmount if there is no amount for this value');
        }

        $this->taxBasisTotalAmount = new Amount($taxBasisTotalAmount);
        $this->grandTotalAmount = new Amount($grandTotalAmount);
        $this->amountDueForPayment = new Amount($amountDueForPayment);
        $this->taxTotalAmount = $taxTotalAmount !== null ? new Amount($taxBasisTotalAmount) : null;
        $this->currencyID = $currencyID;
    }

    public function getTaxBasisTotalAmount(): float
    {
        return $this->taxBasisTotalAmount->getValueRounded();
    }

    public function getTaxTotalAmount(): ?float
    {
        return $this->taxTotalAmount?->getValueRounded();
    }

    public function getCurrencyID(): ?string
    {
        return $this->currencyID;
    }

    public function getGrandTotalAmount(): float
    {
        return $this->grandTotalAmount->getValueRounded();
    }

    public function getAmountDueForPayment(): float
    {
        return $this->amountDueForPayment->getValueRounded();
    }
}