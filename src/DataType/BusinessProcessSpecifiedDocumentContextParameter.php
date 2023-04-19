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
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @throws \DOMException
     */
    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:BusinessProcessSpecifiedDocumentContextParameter');

        $currentNode->appendChild($document->createElement('ram:ID', $this->id));

        return $currentNode;
    }
}
