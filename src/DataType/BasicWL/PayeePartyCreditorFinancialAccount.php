<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\EN16931\DataType\Identifier\PaymentAccountIdentifier;

/**
 * BG-17.
 */
class PayeePartyCreditorFinancialAccount
{
    protected const XML_NODE = 'ram:PayeePartyCreditorFinancialAccount';

    /**
     * BT-84.
     */
    private ?PaymentAccountIdentifier $ibanIdentifier;

    /**
     * BT-84-0.
     */
    private ?PaymentAccountIdentifier $proprietaryIdentifier;

    public function __construct(
        ?PaymentAccountIdentifier $ibanIdentifier = null,
        ?PaymentAccountIdentifier $proprietaryIdentifier = null
    ) {
        $this->ibanIdentifier        = $ibanIdentifier;
        $this->proprietaryIdentifier = $proprietaryIdentifier;
    }

    public function getIbanIdentifier(): ?PaymentAccountIdentifier
    {
        return $this->ibanIdentifier;
    }

    public function setIbanIdentifier(?PaymentAccountIdentifier $ibanIdentifier): void
    {
        $this->ibanIdentifier = $ibanIdentifier;
    }

    public function getProprietaryIdentifier(): ?PaymentAccountIdentifier
    {
        return $this->proprietaryIdentifier;
    }

    public function setProprietaryIdentifier(?PaymentAccountIdentifier $proprietaryIdentifier): void
    {
        $this->proprietaryIdentifier = $proprietaryIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        if ($this->ibanIdentifier instanceof PaymentAccountIdentifier) {
            $element->appendChild($document->createElement('ram:IBANID', $this->ibanIdentifier->value));
        }

        if ($this->proprietaryIdentifier instanceof PaymentAccountIdentifier) {
            $element->appendChild($document->createElement('ram:ProprietaryID', $this->proprietaryIdentifier->value));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $payeePartyCreditorFinancialAccountElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $payeePartyCreditorFinancialAccountElements->count()) {
            return null;
        }

        if ($payeePartyCreditorFinancialAccountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $payeePartyCreditorFinancialAccountElement */
        $payeePartyCreditorFinancialAccountElement = $payeePartyCreditorFinancialAccountElements->item(0);

        $ibanIdentifierElements        = $xpath->query('.//ram:IBANID', $payeePartyCreditorFinancialAccountElement);
        $proprietaryIdentifierElements = $xpath->query('.//ram:ProprietaryID', $payeePartyCreditorFinancialAccountElement);

        if ($ibanIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($proprietaryIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $payeePartyCreditorFinancialAccount = new static();

        if (1 === $ibanIdentifierElements->count()) {
            $payeePartyCreditorFinancialAccount->setIbanIdentifier(new PaymentAccountIdentifier($ibanIdentifierElements->item(0)->nodeValue));
        }

        if (1 === $proprietaryIdentifierElements->count()) {
            $payeePartyCreditorFinancialAccount->setProprietaryIdentifier(new PaymentAccountIdentifier($proprietaryIdentifierElements->item(0)->nodeValue));
        }

        return $payeePartyCreditorFinancialAccount;
    }
}
