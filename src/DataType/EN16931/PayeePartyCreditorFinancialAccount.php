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

    public function __construct()
    {
        parent::__construct();

        $this->accountName = null;
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
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->ibanIdentifier instanceof PaymentAccountIdentifier) {
            $currentNode->appendChild($document->createElement('ram:IBANID', $this->ibanIdentifier->value));
        }

        if (\is_string($this->accountName)) {
            $currentNode->appendChild($document->createElement('ram:AccountName', $this->accountName));
        }

        if ($this->proprietaryIdentifier instanceof PaymentAccountIdentifier) {
            $currentNode->appendChild($document->createElement('ram:ProprietaryID', $this->proprietaryIdentifier->value));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $payeePartyCreditorFinancialAccountElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $payeePartyCreditorFinancialAccountElements->count()) {
            return null;
        }

        if ($payeePartyCreditorFinancialAccountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $payeePartyCreditorFinancialAccountElement */
        $payeePartyCreditorFinancialAccountElement = $payeePartyCreditorFinancialAccountElements->item(0);

        $ibanIdentifierElements        = $xpath->query('./ram:IBANID', $payeePartyCreditorFinancialAccountElement);
        $accountNameElements           = $xpath->query('./ram:AccountName', $payeePartyCreditorFinancialAccountElement);
        $proprietaryIdentifierElements = $xpath->query('./ram:ProprietaryID', $payeePartyCreditorFinancialAccountElement);

        if ($ibanIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($accountNameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($proprietaryIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $payeePartyCreditorFinancialAccount = new self();

        if (1 === $ibanIdentifierElements->count()) {
            $payeePartyCreditorFinancialAccount->setIbanIdentifier(new PaymentAccountIdentifier($ibanIdentifierElements->item(0)->nodeValue));
        }

        if (1 === $accountNameElements->count()) {
            $payeePartyCreditorFinancialAccount->setAccountName($accountNameElements->item(0)->nodeValue);
        }

        if (1 === $proprietaryIdentifierElements->count()) {
            $payeePartyCreditorFinancialAccount->setProprietaryIdentifier(new PaymentAccountIdentifier($proprietaryIdentifierElements->item(0)->nodeValue));
        }

        return $payeePartyCreditorFinancialAccount;
    }
}
