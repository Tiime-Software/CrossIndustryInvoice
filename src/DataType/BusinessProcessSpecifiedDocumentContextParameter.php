<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-23-00.
 */
class BusinessProcessSpecifiedDocumentContextParameter
{
    /**
     * BT-23.
     */
    private string $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @throws \DOMException
     */
    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:BusinessProcessSpecifiedDocumentContextParameter');

        $currentNode->appendChild($document->createElement('ram:ID', $this->identifier));

        return $currentNode;
    }
}
