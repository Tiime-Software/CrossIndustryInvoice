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
    private SpecificationIdentifier $id;

    public function __construct(SpecificationIdentifier $id)
    {
        $this->id = $id;
    }

    public function getId(): SpecificationIdentifier
    {
        return $this->id;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:GuidelineSpecifiedDocumentContextParameter');

        $currentNode->appendChild($document->createElement('ram:ID', $this->id->value));

        return $currentNode;
    }
}
