<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\EN16931\BusinessTermsGroup\DeliverToAddress;
use Tiime\EN16931\BusinessTermsGroup\DeliveryInformation;
use Tiime\EN16931\DataType\Identifier\LocationIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BG-13.
 */
class ShipToTradeParty
{
    protected const string XML_NODE = 'ram:ShipToTradeParty';

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
        $element = $document->createElement(self::XML_NODE);

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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $shipToTradePartyElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $shipToTradePartyElements->count()) {
            return null;
        }

        if ($shipToTradePartyElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $shipToTradePartyElement */
        $shipToTradePartyElement = $shipToTradePartyElements->item(0);

        $identifierElements = $xpath->query('./ram:ID', $shipToTradePartyElement);
        $nameElements       = $xpath->query('./ram:Name', $shipToTradePartyElement);

        if ($identifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($nameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $globalIdentifier   = LocationGlobalIdentifier::fromXML($xpath, $shipToTradePartyElement);
        $postalTradeAddress = PostalTradeAddress::fromXML($xpath, $shipToTradePartyElement);

        $shipToTradeParty = new self();

        if (1 === $identifierElements->count()) {
            $shipToTradeParty->setIdentifier(new LocationIdentifier($identifierElements->item(0)->nodeValue));
        }

        if ($globalIdentifier instanceof LocationGlobalIdentifier) {
            $shipToTradeParty->setGlobalIdentifier($globalIdentifier);
        }

        if (1 === $nameElements->count()) {
            $shipToTradeParty->setName($nameElements->item(0)->nodeValue);
        }

        if ($postalTradeAddress instanceof PostalTradeAddress) {
            $shipToTradeParty->setPostalTradeAddress($postalTradeAddress);
        }

        return $shipToTradeParty;
    }

    public static function fromEN16931(DeliveryInformation $deliveryInformation): self
    {
        $identifier       = null;
        $globalIdentifier = null;

        if ($deliveryInformation->getLocationIdentifier()?->scheme instanceof InternationalCodeDesignator) {
            $globalIdentifier = new LocationGlobalIdentifier(
                $deliveryInformation->getLocationIdentifier()->value,
                $deliveryInformation->getLocationIdentifier()->scheme
            );
        } else {
            $identifier = $deliveryInformation->getLocationIdentifier();
        }

        return (new self())
            ->setIdentifier($identifier)
            ->setGlobalIdentifier($globalIdentifier)
            ->setName($deliveryInformation->getDeliverToPartyName())
            ->setPostalTradeAddress(
                $deliveryInformation->getDeliverToAddress() instanceof DeliverToAddress
                    ? PostalTradeAddress::fromEN16931($deliveryInformation->getDeliverToAddress())
                    : null
            );
    }
}
