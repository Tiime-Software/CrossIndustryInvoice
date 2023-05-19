<?php

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\ItemTypeCode;

class ClassCode
{
    protected const XML_NODE = 'ram:ClassCode';

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
        $this->value                 = $value;
        $this->listIdentifier        = $listIdentifier;
        $this->listVersionIdentifier = null;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getListIdentifier(): ItemTypeCode
    {
        return $this->listIdentifier;
    }

    public function getListVersionIdentifier(): ?string
    {
        return $this->listVersionIdentifier;
    }

    public function setListVersionIdentifier(?string $listVersionIdentifier): static
    {
        $this->listVersionIdentifier = $listVersionIdentifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE, $this->value);
        $currentNode->setAttribute('listID', $this->listIdentifier->value);

        if (\is_string($this->listVersionIdentifier)) {
            $currentNode->setAttribute('listVersionID', $this->listVersionIdentifier);
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $classCodeElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $classCodeElements->count()) {
            return null;
        }

        if ($classCodeElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $classCodeElement */
        $classCodeElement = $classCodeElements->item(0);

        $value = $classCodeElement->nodeValue;

        $identifier = ItemTypeCode::tryFrom($classCodeElement->getAttribute('listID'));

        if (!$identifier instanceof ItemTypeCode) {
            throw new \Exception('Wrong listID');
        }

        $classCode = new self($value, $identifier);

        if ($classCodeElement->hasAttribute('listVersionID')) {
            $listVersionIdentifier = $classCodeElement->getAttribute('listVersionID');

            $classCode->setListVersionIdentifier($listVersionIdentifier);
        }

        return $classCode;
    }
}
