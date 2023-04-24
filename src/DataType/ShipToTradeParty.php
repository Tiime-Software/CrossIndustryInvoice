<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\EN16931\DataType\Identifier\LocationIdentifier;

/**
 * BG-13.
 */
class ShipToTradeParty
{
    /**
     * BT-71.
     */
    private ?LocationIdentifier $identifier;

    /**
     * BT-71-0 & BT-71-1.
     */
    private ?LocationGlobalIdentifier $globalIdentifier;

    /**
     * BT-70.
     */
    private ?string $name;

    /**
     * BG-15.
     */
    private ?PostalTradeAddress $postalTradeAddress;

    public function __construct()
    {
        $this->identifier         = null;
        $this->globalIdentifier   = null;
        $this->name               = null;
        $this->postalTradeAddress = null;
    }

    public function getIdentifier(): ?LocationIdentifier
    {
        return $this->identifier;
    }

    public function setIdentifier(?LocationIdentifier $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getGlobalIdentifier(): ?LocationGlobalIdentifier
    {
        return $this->globalIdentifier;
    }

    public function setGlobalIdentifier(?LocationGlobalIdentifier $globalIdentifier): static
    {
        $this->globalIdentifier = $globalIdentifier;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPostalTradeAddress(): ?PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function setPostalTradeAddress(?PostalTradeAddress $postalTradeAddress): static
    {
        $this->postalTradeAddress = $postalTradeAddress;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ShipToTradeParty');

        if ($this->identifier instanceof LocationIdentifier) {
            $element->appendChild($document->createElement('ram:ID', $this->identifier->value));
        }

        if ($this->globalIdentifier instanceof LocationGlobalIdentifier) {
            $globalIdentifierElement = $document->createElement('ram:GlobalID', $this->globalIdentifier->value);

            $globalIdentifierElement->setAttribute('schemeID', $this->globalIdentifier->scheme->value);

            $element->appendChild($globalIdentifierElement);
        }

        if (\is_string($this->name)) {
            $element->appendChild($document->createElement('ram:Name', $this->name));
        }

        if ($this->postalTradeAddress instanceof PostalTradeAddress) {
            $element->appendChild($this->postalTradeAddress->toXML($document));
        }

        return $element;
    }
}
