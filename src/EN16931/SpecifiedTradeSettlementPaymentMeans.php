<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\PayerPartyDebtorFinancialAccount;
use Tiime\EN16931\DataType\PaymentMeansCode;

/**
 * BG-16.
 */
class SpecifiedTradeSettlementPaymentMeans
{
    /**
     * BT-81.
     */
    private PaymentMeansCode $typeCode;

    /**
     * BT-82.
     */
    private ?string $information;

    /**
     * BG-18.
     */
    private ?ApplicableTradeSettlementFinancialCard $applicableTradeSettlementFinancialCard;

    /**
     * BT-91-00.
     */
    private ?PayerPartyDebtorFinancialAccount $payerPartyDebtorFinancialAccount;

    /**
     * BG-17.
     */
    private ?PayeePartyCreditorFinancialAccount $payeePartyCreditorFinancialAccount;

    /**
     * BT-86-00.
     */
    private ?PayeeSpecifiedCreditorFinancialInstitution $payeeSpecifiedCreditorFinancialInstitution;

    public function __construct(PaymentMeansCode $typeCode)
    {
        $this->typeCode                                   = $typeCode;
        $this->information                                = null;
        $this->applicableTradeSettlementFinancialCard     = null;
        $this->payerPartyDebtorFinancialAccount           = null;
        $this->payeePartyCreditorFinancialAccount         = null;
        $this->payeeSpecifiedCreditorFinancialInstitution = null;
    }

    public function getTypeCode(): PaymentMeansCode
    {
        return $this->typeCode;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(?string $information): void
    {
        $this->information = $information;
    }

    public function getApplicableTradeSettlementFinancialCard(): ?ApplicableTradeSettlementFinancialCard
    {
        return $this->applicableTradeSettlementFinancialCard;
    }

    public function setApplicableTradeSettlementFinancialCard(?ApplicableTradeSettlementFinancialCard $applicableTradeSettlementFinancialCard): void
    {
        $this->applicableTradeSettlementFinancialCard = $applicableTradeSettlementFinancialCard;
    }

    public function getPayerPartyDebtorFinancialAccount(): ?PayerPartyDebtorFinancialAccount
    {
        return $this->payerPartyDebtorFinancialAccount;
    }

    public function setPayerPartyDebtorFinancialAccount(?PayerPartyDebtorFinancialAccount $payerPartyDebtorFinancialAccount): void
    {
        $this->payerPartyDebtorFinancialAccount = $payerPartyDebtorFinancialAccount;
    }

    public function getPayeePartyCreditorFinancialAccount(): ?PayeePartyCreditorFinancialAccount
    {
        return $this->payeePartyCreditorFinancialAccount;
    }

    public function setPayeePartyCreditorFinancialAccount(?PayeePartyCreditorFinancialAccount $payeePartyCreditorFinancialAccount): void
    {
        $this->payeePartyCreditorFinancialAccount = $payeePartyCreditorFinancialAccount;
    }

    public function getPayeeSpecifiedCreditorFinancialInstitution(): ?PayeeSpecifiedCreditorFinancialInstitution
    {
        return $this->payeeSpecifiedCreditorFinancialInstitution;
    }

    public function setPayeeSpecifiedCreditorFinancialInstitution(?PayeeSpecifiedCreditorFinancialInstitution $payeeSpecifiedCreditorFinancialInstitution): void
    {
        $this->payeeSpecifiedCreditorFinancialInstitution = $payeeSpecifiedCreditorFinancialInstitution;
    }
}
