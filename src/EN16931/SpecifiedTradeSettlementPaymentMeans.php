<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\ApplicableTradeSettlementFinancialCard;
use Tiime\CrossIndustryInvoice\DataType\EN16931\PayeePartyCreditorFinancialAccount;
use Tiime\CrossIndustryInvoice\DataType\PayeeSpecifiedCreditorFinancialInstitution;
use Tiime\CrossIndustryInvoice\DataType\PayerPartyDebtorFinancialAccount;
use Tiime\EN16931\BusinessTermsGroup\CreditTransfer;
use Tiime\EN16931\BusinessTermsGroup\PaymentCardInformation;
use Tiime\EN16931\BusinessTermsGroup\PaymentInstructions;
use Tiime\EN16931\DataType\Identifier\DebitedAccountIdentifier;
use Tiime\EN16931\DataType\Identifier\PaymentServiceProviderIdentifier;
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

    public function setInformation(?string $information): static
    {
        $this->information = $information;

        return $this;
    }

    public function getApplicableTradeSettlementFinancialCard(): ?ApplicableTradeSettlementFinancialCard
    {
        return $this->applicableTradeSettlementFinancialCard;
    }

    public function setApplicableTradeSettlementFinancialCard(?ApplicableTradeSettlementFinancialCard $applicableTradeSettlementFinancialCard): static
    {
        $this->applicableTradeSettlementFinancialCard = $applicableTradeSettlementFinancialCard;

        return $this;
    }

    public function getPayerPartyDebtorFinancialAccount(): ?PayerPartyDebtorFinancialAccount
    {
        return $this->payerPartyDebtorFinancialAccount;
    }

    public function setPayerPartyDebtorFinancialAccount(?PayerPartyDebtorFinancialAccount $payerPartyDebtorFinancialAccount): static
    {
        $this->payerPartyDebtorFinancialAccount = $payerPartyDebtorFinancialAccount;

        return $this;
    }

    public function getPayeePartyCreditorFinancialAccount(): ?PayeePartyCreditorFinancialAccount
    {
        return $this->payeePartyCreditorFinancialAccount;
    }

    public function setPayeePartyCreditorFinancialAccount(?PayeePartyCreditorFinancialAccount $payeePartyCreditorFinancialAccount): static
    {
        $this->payeePartyCreditorFinancialAccount = $payeePartyCreditorFinancialAccount;

        return $this;
    }

    public function getPayeeSpecifiedCreditorFinancialInstitution(): ?PayeeSpecifiedCreditorFinancialInstitution
    {
        return $this->payeeSpecifiedCreditorFinancialInstitution;
    }

    public function setPayeeSpecifiedCreditorFinancialInstitution(?PayeeSpecifiedCreditorFinancialInstitution $payeeSpecifiedCreditorFinancialInstitution): static
    {
        $this->payeeSpecifiedCreditorFinancialInstitution = $payeeSpecifiedCreditorFinancialInstitution;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:SpecifiedTradeSettlementPaymentMeans');

        $currentNode->appendChild($document->createElement('ram:TypeCode', $this->typeCode->value));

        if (null !== $this->information) {
            $currentNode->appendChild($document->createElement('ram:Information', $this->information));
        }

        if (null !== $this->applicableTradeSettlementFinancialCard) {
            $currentNode->appendChild($this->applicableTradeSettlementFinancialCard->toXML($document));
        }

        if (null !== $this->payerPartyDebtorFinancialAccount) {
            $currentNode->appendChild($this->payerPartyDebtorFinancialAccount->toXML($document));
        }

        if (null !== $this->payeePartyCreditorFinancialAccount) {
            $currentNode->appendChild($this->payeePartyCreditorFinancialAccount->toXML($document));
        }

        if (null !== $this->payeeSpecifiedCreditorFinancialInstitution) {
            $currentNode->appendChild($this->payeeSpecifiedCreditorFinancialInstitution->toXML($document));
        }

        return $currentNode;
    }

    public static function fromEN16931(PaymentInstructions $paymentInstructions): static
    {
        $creditTransfers = $paymentInstructions->getCreditTransfers();

        if (\count($creditTransfers) > 1) {
            throw new \Exception("Found multiple CreditTransfers but CII's cardinalities only allow a maximum of 1 occurrence.");
        }

        $creditTransfer = array_pop($creditTransfers);

        return (new self($paymentInstructions->getPaymentMeansTypeCode()))
            ->setInformation($paymentInstructions->getPaymentMeansText())
            ->setApplicableTradeSettlementFinancialCard(
                $paymentInstructions->getPaymentCardInformation() instanceof PaymentCardInformation
                    ? ApplicableTradeSettlementFinancialCard::fromEN16931($paymentInstructions->getPaymentCardInformation())
                    : null
            )
            ->setPayerPartyDebtorFinancialAccount(
                $paymentInstructions->getDirectDebit()->getDebitedAccountIdentifier() instanceof DebitedAccountIdentifier
                    ? new PayerPartyDebtorFinancialAccount($paymentInstructions->getDirectDebit()->getDebitedAccountIdentifier())
                    : null
            )
            ->setPayeePartyCreditorFinancialAccount(
                $creditTransfer instanceof CreditTransfer
                    ? PayeePartyCreditorFinancialAccount::fromEN16931($creditTransfer)
                    : null
            )
            ->setPayeeSpecifiedCreditorFinancialInstitution(
                $creditTransfer?->getPaymentServiceProviderIdentifier() instanceof PaymentServiceProviderIdentifier
                    ? new PayeeSpecifiedCreditorFinancialInstitution($creditTransfer->getPaymentServiceProviderIdentifier())
                    : null
            );
    }
}
