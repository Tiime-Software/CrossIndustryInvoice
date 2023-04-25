<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\DebitedAccountIdentifier;

/**
 * BT-91-00.
 */
class PayerPartyDebtorFinancialAccount
{
    /**
     * BT-91.
     */
    private DebitedAccountIdentifier $ibanIdentifier;

    public function __construct(DebitedAccountIdentifier $ibanIdentifier)
    {
        $this->ibanIdentifier = $ibanIdentifier;
    }

    public function getIbanIdentifier(): DebitedAccountIdentifier
    {
        return $this->ibanIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:PayerPartyDebtorFinancialAccount');

        $element->appendChild($document->createElement('ram:IBANID', $this->ibanIdentifier->value));

        return $element;
    }
}
