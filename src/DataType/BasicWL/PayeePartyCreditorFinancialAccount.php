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
    private ?PaymentAccountIdentifier $ibanId;

    /**
     * BT-84-0.
     */
    private ?PaymentAccountIdentifier $proprietaryId;

    public function __construct(
        ?PaymentAccountIdentifier $ibanId = null,
        ?PaymentAccountIdentifier $proprietaryId = null
    ) {
        $this->ibanId        = $ibanId;
        $this->proprietaryId = $proprietaryId;
    }

    public function getIbanId(): ?PaymentAccountIdentifier
    {
        return $this->ibanId;
    }

    public function getProprietaryId(): ?PaymentAccountIdentifier
    {
        return $this->proprietaryId;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:PayeePartyCreditorFinancialAccount');

        if ($this->ibanId instanceof PaymentAccountIdentifier) {
            $element->appendChild($document->createElement('ram:IBANID', $this->ibanId->value));
        }

        if ($this->proprietaryId instanceof PaymentAccountIdentifier) {
            $element->appendChild($document->createElement('ram:ProprietaryID', $this->proprietaryId->value));
        }

        return $element;
    }
}
