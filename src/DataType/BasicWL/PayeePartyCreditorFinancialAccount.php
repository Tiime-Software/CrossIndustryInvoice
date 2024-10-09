<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\EN16931\DataType\Identifier\PaymentAccountIdentifier;

/**
 * BG-17.
 */
class PayeePartyCreditorFinancialAccount
{
    protected const string XML_NODE = 'ram:PayeePartyCreditorFinancialAccount';

    /**
     * BT-84.
     */
    protected ?PaymentAccountIdentifier $ibanIdentifier;

    /**
     * BT-84-0.
     */
    protected ?PaymentAccountIdentifier $proprietaryIdentifier;

    public function __construct()
    {
        $this->ibanIdentifier        = null;
        $this->proprietaryIdentifier = null;
    }

    public function getIbanIdentifier(): ?PaymentAccountIdentifier
    {
        return $this->ibanIdentifier;
    }

    public function setIbanIdentifier(?PaymentAccountIdentifier $ibanIdentifier): static
    {
        $this->ibanIdentifier = $ibanIdentifier;

        return $this;
    }

    public function getProprietaryIdentifier(): ?PaymentAccountIdentifier
    {
        return $this->proprietaryIdentifier;
    }

    public function setProprietaryIdentifier(?PaymentAccountIdentifier $proprietaryIdentifier): static
    {
        $this->proprietaryIdentifier = $proprietaryIdentifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): ?\DOMElement
    {
        if (
            null    === $this->ibanIdentifier
            && null === $this->proprietaryIdentifier
        ) {
            return null;
        }

        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->ibanIdentifier instanceof PaymentAccountIdentifier) {
            $currentNode->appendChild($document->createElement('ram:IBANID', $this->ibanIdentifier->value));
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
        $proprietaryIdentifierElements = $xpath->query('./ram:ProprietaryID', $payeePartyCreditorFinancialAccountElement);

        if ($ibanIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($proprietaryIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $payeePartyCreditorFinancialAccount = new self();

        if (1 === $ibanIdentifierElements->count()) {
            $payeePartyCreditorFinancialAccount->setIbanIdentifier(new PaymentAccountIdentifier($ibanIdentifierElements->item(0)->nodeValue));
        }

        if (1 === $proprietaryIdentifierElements->count()) {
            $payeePartyCreditorFinancialAccount->setProprietaryIdentifier(new PaymentAccountIdentifier($proprietaryIdentifierElements->item(0)->nodeValue));
        }

        return $payeePartyCreditorFinancialAccount;
    }
}
