<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\PaymentServiceProviderIdentifier;

class PayeeSpecifiedCreditorFinancialInstitution
{
    protected const XML_NODE = 'ram:PayeeSpecifiedCreditorFinancialInstitution';

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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:BICID', $this->bicIdentifier->value));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $payeeSpecifiedCreditorFinancialInstitutionElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $payeeSpecifiedCreditorFinancialInstitutionElements->count()) {
            return null;
        }

        if ($payeeSpecifiedCreditorFinancialInstitutionElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $payeeSpecifiedCreditorFinancialInstitutionElement */
        $payeeSpecifiedCreditorFinancialInstitutionElement = $payeeSpecifiedCreditorFinancialInstitutionElements->item(0);

        $bicIdentifierElements = $xpath->query('.//ram:BICID', $payeeSpecifiedCreditorFinancialInstitutionElement);

        if (1 !== $bicIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $bicIdentifier = $bicIdentifierElements->item(0)->nodeValue;

        return new self(new PaymentServiceProviderIdentifier($bicIdentifier));
    }
}
