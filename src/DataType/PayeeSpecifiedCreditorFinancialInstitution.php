<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\PaymentServiceProviderIdentifier;

class PayeeSpecifiedCreditorFinancialInstitution
{
    /**
     * BT-86.
     */
    private PaymentServiceProviderIdentifier $bicIdentifier;

    public function __construct(PaymentServiceProviderIdentifier $bicIdentifier)
    {
        $this->bicIdentifier = $bicIdentifier;
    }

    public function getBicIdentifier(): PaymentServiceProviderIdentifier
    {
        return $this->bicIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:PayeeSpecifiedCreditorFinancialInstitution');

        $currentNode->appendChild($document->createElement('ram:BICID', $this->bicIdentifier->value));

        return $currentNode;
    }
}
