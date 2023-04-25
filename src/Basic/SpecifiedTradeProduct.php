<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\EN16931\DataType\Identifier\StandardItemIdentifier;

class SpecifiedTradeProduct
{
    /**
     * BT-157.
     */
    private ?StandardItemIdentifier $globalIdentifier;

    /**
     * BT-153.
     */
    private string $name;

    public function __construct(string $name)
    {
        $this->globalIdentifier = null;
        $this->name             = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGlobalIdentifier(): ?StandardItemIdentifier
    {
        return $this->globalIdentifier;
    }

    public function setGlobalIdentifier(?StandardItemIdentifier $globalIdentifier): self
    {
        $this->globalIdentifier = $globalIdentifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTradeProduct');

        if ($this->getGlobalIdentifier() instanceof StandardItemIdentifier) {
            $identifierElement = $document->createElement('ram:GlobalID', $this->getGlobalIdentifier()->value);
            $identifierElement->setAttribute('schemeID', $this->getGlobalIdentifier()->scheme->value);

            $element->appendChild($identifierElement);
        }

        $element->appendChild($document->createElement('ram:Name', $this->getName()));

        return $element;
    }
}
