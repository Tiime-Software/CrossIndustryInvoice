<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-32-00.
 */
class SpecifiedTaxRegistrationFC
{
    protected const string XML_NODE = 'ram:SpecifiedTaxRegistration';

    /**
     * BT-32-0.
     */
    private string $schemeIdentifier;

    /**
     * @param VatIdentifier $identifier - BT-32
     */
    public function __construct(private readonly VatIdentifier $identifier)
    {
        $this->schemeIdentifier = 'FC';
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

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): ?self
    {
        $specifiedTaxRegistrationElements = $xpath->query(\sprintf('./%s[ram:ID[@schemeID = \'FC\']]', self::XML_NODE), $currentElement);

        if (0 === $specifiedTaxRegistrationElements->count()) {
            return null;
        }

        if ($specifiedTaxRegistrationElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedTaxRegistrationElement */
        $specifiedTaxRegistrationElement = $specifiedTaxRegistrationElements->item(0);

        $identifierElements = $xpath->query('./ram:ID', $specifiedTaxRegistrationElement);

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

        if ('FC' !== $schemeIdentifier) {
            throw new \Exception('Wrong schemeID');
        }

        return new self(new VatIdentifier($identifier));
    }
}
