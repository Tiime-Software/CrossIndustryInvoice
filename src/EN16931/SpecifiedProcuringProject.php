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
    private ProjectReference $id;

    /**
     * BT-11-0.
     */
    private string $name;

    public function __construct(ProjectReference $id)
    {
        $this->id   = $id;
        $this->name = 'Project Reference';
    }

    public function getId(): ProjectReference
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedProcuringProject');

        $element->appendChild($document->createElement('ram:ID', $this->id->value));
        $element->appendChild($document->createElement('ram:Name', $this->name));

        return $element;
    }
}
