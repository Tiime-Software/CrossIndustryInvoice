<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\BuyerGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistration;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\EN16931\DataType\Identifier\BuyerIdentifier;

/**
 * BG-7.
 */
class BuyerTradeParty extends \Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerTradeParty
{
    /**
     * BT-46.
     */
    private ?BuyerIdentifier $identifier;

    /**
     * BT-46-0 & BT-46-1.
     */
    private ?BuyerGlobalIdentifier $globalIdentifier;

    /**
     * BG-8.
     */
    private PostalTradeAddress $postalTradeAddress;

    /**
     * BT-49-00.
     */
    private ?URIUniversalCommunication $URIUniversalCommunication;

    /**
     * BT-48-00.
     */
    private ?SpecifiedTaxRegistration $specifiedTaxRegistration;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        parent::__construct($name);

        $this->postalTradeAddress         = $postalTradeAddress;
        $this->identifier                 = null;
        $this->globalIdentifier           = null;
        $this->URIUniversalCommunication  = null;
        $this->specifiedTaxRegistration   = null;
    }

    public function getIdentifier(): ?BuyerIdentifier
    {
        return $this->identifier;
    }

    public function setIdentifier(?BuyerIdentifier $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getGlobalIdentifier(): ?BuyerGlobalIdentifier
    {
        return $this->globalIdentifier;
    }

    public function setGlobalIdentifier(?BuyerGlobalIdentifier $globalIdentifier): static
    {
        $this->globalIdentifier = $globalIdentifier;

        return $this;
    }

    public function getPostalTradeAddress(): PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function getURIUniversalCommunication(): ?URIUniversalCommunication
    {
        return $this->URIUniversalCommunication;
    }

    public function setURIUniversalCommunication(?URIUniversalCommunication $URIUniversalCommunication): static
    {
        $this->URIUniversalCommunication = $URIUniversalCommunication;

        return $this;
    }

    public function getSpecifiedTaxRegistration(): ?SpecifiedTaxRegistration
    {
        return $this->specifiedTaxRegistration;
    }

    public function setSpecifiedTaxRegistration(?SpecifiedTaxRegistration $specifiedTaxRegistration): static
    {
        $this->specifiedTaxRegistration = $specifiedTaxRegistration;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->identifier instanceof BuyerIdentifier) {
            $currentNode->appendChild($document->createElement('ram:ID', $this->identifier->value));
        }

        if ($this->globalIdentifier instanceof BuyerGlobalIdentifier) {
            $currentNode->appendChild($this->globalIdentifier->toXML($document));
        }

        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        if ($this->specifiedLegalOrganization instanceof BuyerSpecifiedLegalOrganization) {
            $currentNode->appendChild($this->specifiedLegalOrganization->toXML($document));
        }

        $currentNode->appendChild($this->postalTradeAddress->toXML($document));

        if ($this->URIUniversalCommunication instanceof URIUniversalCommunication) {
            $currentNode->appendChild($this->URIUniversalCommunication->toXML($document));
        }

        if ($this->specifiedTaxRegistration instanceof SpecifiedTaxRegistration) {
            $currentNode->appendChild($this->specifiedTaxRegistration->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $buyerTradePartyElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $buyerTradePartyElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $buyerTradePartyElement */
        $buyerTradePartyElement = $buyerTradePartyElements->item(0);

        $identifierElements = $xpath->query('.//ram:ID', $buyerTradePartyElement);
        $nameElements       = $xpath->query('.//ram:Name', $buyerTradePartyElement);

        if ($identifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $globalIdentifier           = BuyerGlobalIdentifier::fromXML($xpath, $buyerTradePartyElement);
        $specifiedLegalOrganization = BuyerSpecifiedLegalOrganization::fromXML($xpath, $buyerTradePartyElement);
        $postalTradeAddress         = PostalTradeAddress::fromXML($xpath, $buyerTradePartyElement);
        $URIUniversalCommunication  = URIUniversalCommunication::fromXML($xpath, $buyerTradePartyElement);
        $specifiedTaxRegistration   = SpecifiedTaxRegistration::fromXML($xpath, $buyerTradePartyElement);

        if (null === $postalTradeAddress) {
            throw new \Exception('Malformed');
        }

        if (\count($specifiedTaxRegistration) > 1) {
            throw new \Exception('Malformed');
        }

        $buyerTradeParty = new self($name, $postalTradeAddress);

        if (1 === $identifierElements->count()) {
            $buyerTradeParty->setIdentifier(new BuyerIdentifier($identifierElements->item(0)->nodeValue));
        }

        if ($globalIdentifier instanceof BuyerGlobalIdentifier) {
            $buyerTradeParty->setGlobalIdentifier($globalIdentifier);
        }

        if ($specifiedLegalOrganization instanceof BuyerSpecifiedLegalOrganization) {
            $buyerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        if ($URIUniversalCommunication instanceof URIUniversalCommunication) {
            $buyerTradeParty->setURIUniversalCommunication($URIUniversalCommunication);
        }

        if (1 === \count($specifiedTaxRegistration)) {
            $buyerTradeParty->setSpecifiedTaxRegistration($specifiedTaxRegistration[0]);
        }

        return $buyerTradeParty;
    }
}
