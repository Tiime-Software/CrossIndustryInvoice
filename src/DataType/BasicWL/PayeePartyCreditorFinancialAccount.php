<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\EN16931\DataType\Identifier\PaymentAccountIdentifier;

/**
 * BG-17.
 */
class PayeePartyCreditorFinancialAccount
{
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

    public function getProprietaryIdentifier(): ?PaymentAccountIdentifier
    {
        return $this->proprietaryIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:PayeePartyCreditorFinancialAccount');

        if ($this->ibanIdentifier instanceof PaymentAccountIdentifier) {
            $element->appendChild($document->createElement('ram:IBANID', $this->ibanIdentifier->value));
        }

        if ($this->proprietaryIdentifier instanceof PaymentAccountIdentifier) {
            $element->appendChild($document->createElement('ram:ProprietaryID', $this->proprietaryIdentifier->value));
        }

        return $element;
    }
}
