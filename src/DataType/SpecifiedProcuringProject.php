<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\ProjectReference;

/**
 * BT-11-00.
 */
class SpecifiedProcuringProject
{
    protected const string XML_NODE = 'ram:SpecifiedProcuringProject';

    /**
     * BT-11-0.
     */
    private string $name;

    /**
     * @param ProjectReference $identifier - BT-11
     */
    public function __construct(private readonly ProjectReference $identifier)
    {
        $this->name = 'Project Reference';
    }

    public function getIdentifier(): ProjectReference
    {
        return $this->identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:ID', $this->identifier->value));
        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $specifiedProcuringProjectElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $specifiedProcuringProjectElements->count()) {
            return null;
        }

        if ($specifiedProcuringProjectElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedProcuringProjectElement */
        $specifiedProcuringProjectElement = $specifiedProcuringProjectElements->item(0);

        $identifierElements = $xpath->query('./ram:ID', $specifiedProcuringProjectElement);
        $nameElements       = $xpath->query('./ram:Name', $specifiedProcuringProjectElement);

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $identifier = $identifierElements->item(0)->nodeValue;
        $name       = $nameElements->item(0)->nodeValue;

        if (mb_strtolower('Project Reference') !== mb_strtolower($name)) {
            throw new \Exception('Wrong Name');
        }

        return new self(new ProjectReference($identifier));
    }
}
