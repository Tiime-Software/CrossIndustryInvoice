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
    private ItemTypeCode $listID;

    /**
     * BT-158-2.
     */
    private ?string $listVersionID;

    public function __construct(string $value, ItemTypeCode $listID)
    {
        $this->value         = $value;
        $this->listID        = $listID;
        $this->listVersionID = null;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getListID(): ItemTypeCode
    {
        return $this->listID;
    }

    public function getListVersionID(): ?string
    {
        return $this->listVersionID;
    }

    public function setListVersionID(?string $listVersionID): void
    {
        $this->listVersionID = $listVersionID;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ClassCode', $this->value);

        $element->setAttribute('listID', $this->listID->value);

        if (\is_string($this->listVersionID)) {
            $element->setAttribute('listVersionID', $this->listVersionID);
        }

        return $element;
    }
}
