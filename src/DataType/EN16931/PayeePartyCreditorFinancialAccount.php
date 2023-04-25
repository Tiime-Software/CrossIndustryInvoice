<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\EN16931\DataType\Identifier\PaymentAccountIdentifier;

class PayeePartyCreditorFinancialAccount extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeePartyCreditorFinancialAccount
{
    /**
     * BT-85.
     */
    private ?string $accountName;

    public function __construct(
        ?PaymentAccountIdentifier $ibanIdentifier = null,
        ?string $accountName = null,
        ?PaymentAccountIdentifier $proprietaryIdentifier = null
    ) {
        parent::__construct($ibanIdentifier, $proprietaryIdentifier);

        $this->accountName = $accountName;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(?string $accountName): static
    {
        $this->accountName = $accountName;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:PayeePartyCreditorFinancialAccount');

        if (null !== $this->getIbanIdentifier()) {
            $currentNode->appendChild($document->createElement('ram:IBANID', $this->getIbanIdentifier()->value));
        }

        if (null !== $this->accountName) {
            $currentNode->appendChild($document->createElement('ram:AccountName', $this->accountName));
        }

        if (null !== $this->getProprietaryIdentifier()) {
            $currentNode->appendChild($document->createElement('ram:ProprietaryID', $this->getProprietaryIdentifier()->value));
        }

        return $currentNode;
    }
}
