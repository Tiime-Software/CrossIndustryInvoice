<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\Reference\ProjectReference;

/**
 * BT-11-00.
 */
class SpecifiedProcuringProject
{
    /**
     * BT-11.
     */
    private ProjectReference $identifier;

    /**
     * BT-11-0.
     */
    private string $name;

    public function __construct(ProjectReference $identifier)
    {
        $this->identifier = $identifier;
        $this->name       = 'Project Reference';
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
        $element = $document->createElement('ram:SpecifiedProcuringProject');

        $element->appendChild($document->createElement('ram:ID', $this->identifier->value));
        $element->appendChild($document->createElement('ram:Name', $this->name));

        return $element;
    }
}
