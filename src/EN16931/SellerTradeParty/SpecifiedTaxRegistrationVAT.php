<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-31-00.
 */
class SpecifiedTaxRegistrationVAT
{
    protected const XML_NODE = 'ram:SpecifiedTaxRegistration';

    /**
     * BT-31.
     */
    private VatIdentifier $identifier;

    /**
     * BT-31-0.
     */
    private string $schemeIdentifier;

    public function __construct(VatIdentifier $identifier)
    {
        $this->identifier       = $identifier;
        $this->schemeIdentifier = 'VA';
    }

    public function getIdentifier(): VatIdentifier
    {
        return $this->identifier;
    }

    public function getSchemeIdentifier(): string
    {
        return $this->schemeIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $identifierElement = $document->createElement('ram:ID', $this->identifier->getValue());
        $identifierElement->setAttribute('schemeID', $this->schemeIdentifier);
        $currentNode->appendChild($identifierElement);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $specifiedTaxRegistrationVatElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $specifiedTaxRegistrationVatElements->count()) {
            return null;
        }

        if ($specifiedTaxRegistrationVatElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedTaxRegistrationVatElement */
        $specifiedTaxRegistrationVatElement = $specifiedTaxRegistrationVatElements->item(0);

        $identifierElements = $xpath->query('.//ram:ID', $specifiedTaxRegistrationVatElement);

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $identifierItem = $identifierElements->item(0);
        $identifier     = $identifierItem->nodeValue;

        $schemeIdentifier = null;

        if ($identifierItem->hasAttribute('schemeID')) {
            $schemeIdentifier = $identifierItem->getAttribute('schemeID');
        }

        if (!\is_string($schemeIdentifier)) {
            throw new \Exception('Malformed');
        }

        if ('VA' !== $schemeIdentifier) {
            throw new \Exception('Wrong schemeID');
        }

        return new static(new VatIdentifier($identifier));
    }
}
