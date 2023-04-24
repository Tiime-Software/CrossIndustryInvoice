<?php

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\ItemTypeCode;

class ClassCode
{
    /**
     * BT-158.
     */
    private string $value;

    /**
     * BT-158-1.
     */
    private ItemTypeCode $listIdentifier;

    /**
     * BT-158-2.
     */
    private ?string $listVersionIdentifier;

    public function __construct(string $value, ItemTypeCode $listIdentifier)
    {
        $this->value         = $value;
        $this->listIdentifier        = $listIdentifier;
        $this->listVersionIdentifier = null;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return ItemTypeCode
     */
    public function getListIdentifier(): ItemTypeCode
    {
        return $this->listIdentifier;
    }

    /**
     * @return string|null
     */
    public function getListVersionIdentifier(): ?string
    {
        return $this->listVersionIdentifier;
    }

    /**
     * @param string|null $listVersionIdentifier
     */
    public function setListVersionIdentifier(?string $listVersionIdentifier): static
    {
        $this->listVersionIdentifier = $listVersionIdentifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ClassCode', $this->value);

        $element->setAttribute('listID', $this->listIdentifier->value);

        if (\is_string($this->listVersionIdentifier)) {
            $element->setAttribute('listVersionID', $this->listVersionIdentifier);
        }

        return $element;
    }
}
