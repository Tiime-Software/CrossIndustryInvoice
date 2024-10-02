<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\ApplicableTradeSettlementFinancialCard;
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
class SpecifiedTradeSettlementPaymentMeans extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\SpecifiedTradeSettlementPaymentMeans
{
    /**
     * BT-82.
     */
    private ?string $information;

    /**
     * BG-18.
     */
    private ?ApplicableTradeSettlementFinancialCard $applicableTradeSettlementFinancialCard;

    /**
     * BT-86-00.
     */
    private ?PayeeSpecifiedCreditorFinancialInstitution $payeeSpecifiedCreditorFinancialInstitution;

    public function __construct(PaymentMeansCode $typeCode)
    {
        parent::__construct($typeCode);

        $this->information                                = null;
        $this->applicableTradeSettlementFinancialCard     = null;
        $this->payeeSpecifiedCreditorFinancialInstitution = null;
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

    public function setPayeePartyCreditorFinancialAccount(PayeePartyCreditorFinancialAccount|\Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeePartyCreditorFinancialAccount|null $payeePartyCreditorFinancialAccount): static
    {
        if (null !== $payeePartyCreditorFinancialAccount && !$payeePartyCreditorFinancialAccount instanceof PayeePartyCreditorFinancialAccount) {
            throw new \TypeError();
        }

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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:TypeCode', $this->typeCode->value));

        if (\is_string($this->information)) {
            $currentNode->appendChild($document->createElement('ram:Information', $this->information));
        }

        if ($this->applicableTradeSettlementFinancialCard instanceof ApplicableTradeSettlementFinancialCard) {
            $currentNode->appendChild($this->applicableTradeSettlementFinancialCard->toXML($document));
        }

        if ($this->payerPartyDebtorFinancialAccount instanceof PayerPartyDebtorFinancialAccount) {
            $currentNode->appendChild($this->payerPartyDebtorFinancialAccount->toXML($document));
        }

        if ($this->payeePartyCreditorFinancialAccount instanceof PayeePartyCreditorFinancialAccount) {
            $currentNode->appendChild($this->payeePartyCreditorFinancialAccount->toXML($document));
        }

        if ($this->payeeSpecifiedCreditorFinancialInstitution instanceof PayeeSpecifiedCreditorFinancialInstitution) {
            $currentNode->appendChild($this->payeeSpecifiedCreditorFinancialInstitution->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        $specifiedTradeSettlementPaymentMeansElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $specifiedTradeSettlementPaymentMeansElements->count()) {
            return [];
        }

        $outputSpecifiedTradeSettlementPaymentMeans = [];

        /** @var \DOMElement $specifiedTradeSettlementPaymentMeansElement */
        foreach ($specifiedTradeSettlementPaymentMeansElements as $specifiedTradeSettlementPaymentMeansElement) {
            $typeCodeElements    = $xpath->query('./ram:TypeCode', $specifiedTradeSettlementPaymentMeansElement);
            $informationElements = $xpath->query('./ram:Information', $specifiedTradeSettlementPaymentMeansElement);

            if (1 !== $typeCodeElements->count()) {
                throw new \Exception('Malformed');
            }

            if ($informationElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            $typeCode = PaymentMeansCode::tryFrom($typeCodeElements->item(0)->nodeValue);

            if (null === $typeCode) {
                throw new \Exception('Wrong TypeCode');
            }

            $applicableTradeSettlementFinancialCard     = ApplicableTradeSettlementFinancialCard::fromXML($xpath, $specifiedTradeSettlementPaymentMeansElement);
            $payerPartyDebtorFinancialAccount           = PayerPartyDebtorFinancialAccount::fromXML($xpath, $specifiedTradeSettlementPaymentMeansElement);
            $payeePartyCreditorFinancialAccount         = PayeePartyCreditorFinancialAccount::fromXML($xpath, $specifiedTradeSettlementPaymentMeansElement);
            $payeeSpecifiedCreditorFinancialInstitution = PayeeSpecifiedCreditorFinancialInstitution::fromXML($xpath, $specifiedTradeSettlementPaymentMeansElement);

            $specifiedTradeSettlementPaymentMeans = new self($typeCode);

            if (1 === $informationElements->count()) {
                $specifiedTradeSettlementPaymentMeans->setInformation($informationElements->item(0)->nodeValue);
            }

            if ($applicableTradeSettlementFinancialCard instanceof ApplicableTradeSettlementFinancialCard) {
                $specifiedTradeSettlementPaymentMeans->setApplicableTradeSettlementFinancialCard($applicableTradeSettlementFinancialCard);
            }

            if ($payerPartyDebtorFinancialAccount instanceof PayerPartyDebtorFinancialAccount) {
                $specifiedTradeSettlementPaymentMeans->setPayerPartyDebtorFinancialAccount($payerPartyDebtorFinancialAccount);
            }

            if ($payeePartyCreditorFinancialAccount instanceof PayeePartyCreditorFinancialAccount) {
                $specifiedTradeSettlementPaymentMeans->setPayeePartyCreditorFinancialAccount($payeePartyCreditorFinancialAccount);
            }

            if ($payeeSpecifiedCreditorFinancialInstitution instanceof PayeeSpecifiedCreditorFinancialInstitution) {
                $specifiedTradeSettlementPaymentMeans->setPayeeSpecifiedCreditorFinancialInstitution($payeeSpecifiedCreditorFinancialInstitution);
            }

            $outputSpecifiedTradeSettlementPaymentMeans[] = $specifiedTradeSettlementPaymentMeans;
        }

        return $outputSpecifiedTradeSettlementPaymentMeans;
    }

    public static function fromEN16931(PaymentInstructions $paymentInstructions): self
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
