<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;

/**
 * BT-24-00.
 */
class GuidelineSpecifiedDocumentContextParameter
{
    /**
     * BT-24.
     */
    private SpecificationIdentifier $identifier;

    public function __construct(SpecificationIdentifier $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): SpecificationIdentifier
    {
        return $this->identifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:GuidelineSpecifiedDocumentContextParameter');

        $currentNode->appendChild($document->createElement('ram:ID', $this->identifier->value));

        return $currentNode;
    }

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $identifierElements = $xpath->query('//ram:ID');

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $identifier = $identifierElements->item(0)->nodeValue;

        return new static(new SpecificationIdentifier($identifier));
    }
}
