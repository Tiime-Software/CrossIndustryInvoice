<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\BusinessTermsGroup\PaymentCardInformation;

/**
 * BG-18.
 */
class ApplicableTradeSettlementFinancialCard
{
    /**
     * BT-87.
     */
    private string $identifier;

    /**
     * BT-88.
     */
    private ?string $cardholderName;

    public function __construct(string $identifier)
    {
        $this->identifier     = $identifier;
        $this->cardholderName = null;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getCardholderName(): ?string
    {
        return $this->cardholderName;
    }

    public function setCardholderName(?string $cardholderName): static
    {
        $this->cardholderName = $cardholderName;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:ApplicableTradeSettlementFinancialCard');

        $currentNode->appendChild($document->createElement('ram:ID', $this->identifier));

        if (null !== $this->cardholderName) {
            $currentNode->appendChild($document->createElement('ram:CardholderName', $this->cardholderName));
        }

        return $currentNode;
    }

    public static function fromEN16931(PaymentCardInformation $paymentCardInformation): static
    {
        return (new self($paymentCardInformation->getPrimaryAccountNumber()))
            ->setCardholderName($paymentCardInformation->getHolderName());
    }
}
