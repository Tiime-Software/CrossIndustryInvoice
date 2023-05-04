<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-31-00.
 */
class SpecifiedTaxRegistration
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

        $identifierNode = $document->createElement('ram:ID', $this->identifier->getValue());
        $identifierNode->setAttribute('schemeID', $this->schemeIdentifier);
        $currentNode->appendChild($identifierNode);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        $specifiedTaxRegistrationElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $specifiedTaxRegistrationElements->count()) {
            return [];
        }

        $specifiedTaxRegistrations = [];

        foreach ($specifiedTaxRegistrationElements as $specifiedTaxRegistrationElement) {
            $identifierElements = $xpath->query('.//ram:ID', $specifiedTaxRegistrationElement);

            if (1 !== $identifierElements->count()) {
                throw new \Exception('Malformed');
            }

            /** @var \DOMElement $identifierItem */
            $identifierItem = $identifierElements->item(0);
            $identifier     = $identifierItem->nodeValue;

            if ('VA' !== $identifierItem->getAttribute('schemeID')) {
                throw new \Exception('Wrong schemeID');
            }

            $specifiedTaxRegistrations[] = new static(new VatIdentifier($identifier));
        }

        return $specifiedTaxRegistrations;
    }
}
