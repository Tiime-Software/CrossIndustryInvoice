<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;

/**
 * BT-24-00.
 */
class GuidelineSpecifiedDocumentContextParameter
{
    private const XML_NODE = 'ram:GuidelineSpecifiedDocumentContextParameter';

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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:ID', $this->identifier->value));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $guidelineSpecifiedDocumentContextParameterElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $guidelineSpecifiedDocumentContextParameterElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $guidelineSpecifiedDocumentContextParameterElement */
        $guidelineSpecifiedDocumentContextParameterElement = $guidelineSpecifiedDocumentContextParameterElements->item(0);

        $identifierElements = $xpath->query('.//ram:ID', $guidelineSpecifiedDocumentContextParameterElement);

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $identifier = $identifierElements->item(0)->nodeValue;

        return new static(new SpecificationIdentifier($identifier));
    }
}
