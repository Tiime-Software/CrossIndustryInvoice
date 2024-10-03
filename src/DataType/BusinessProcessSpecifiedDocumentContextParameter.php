<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-23-00.
 */
class BusinessProcessSpecifiedDocumentContextParameter
{
    protected const XML_NODE = 'ram:BusinessProcessSpecifiedDocumentContextParameter';

    /**
     * @param string $identifier - BT-23
     */
    public function __construct(
        private string $identifier,
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:ID', $this->identifier));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $businessProcessSpecifiedDocumentContextParameterElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $businessProcessSpecifiedDocumentContextParameterElements->count()) {
            return null;
        }

        if ($businessProcessSpecifiedDocumentContextParameterElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $businessProcessSpecifiedDocumentContextParameterElement */
        $businessProcessSpecifiedDocumentContextParameterElement = $businessProcessSpecifiedDocumentContextParameterElements->item(0);

        $identifierElements = $xpath->query('./ram:ID', $businessProcessSpecifiedDocumentContextParameterElement);

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $identifier = $identifierElements->item(0)->nodeValue;

        return new self($identifier);
    }
}
