<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BuyerGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\DefinedTradeContact;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationVA;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\DataType\Identifier\BuyerIdentifier;

/**
 * BG-7.
 */
class BuyerTradeParty extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\BuyerTradeParty
{
    /**
     * BG-9.
     */
    private ?DefinedTradeContact $definedTradeContact;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        parent::__construct($name, $postalTradeAddress);

        $this->name                       = $name;
        $this->postalTradeAddress         = $postalTradeAddress;
        $this->specifiedLegalOrganization = null;
        $this->definedTradeContact        = null;
    }

    public function getSpecifiedLegalOrganization(): ?BuyerSpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(BuyerSpecifiedLegalOrganization|\Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization|null $specifiedLegalOrganization): static
    {
        if (null !== $specifiedLegalOrganization && !$specifiedLegalOrganization instanceof BuyerSpecifiedLegalOrganization) {
            throw new \TypeError();
        }

        $this->specifiedLegalOrganization = $specifiedLegalOrganization;

        return $this;
    }

    public function getDefinedTradeContact(): ?DefinedTradeContact
    {
        return $this->definedTradeContact;
    }

    public function setDefinedTradeContact(?DefinedTradeContact $definedTradeContact): static
    {
        $this->definedTradeContact = $definedTradeContact;

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
            $specifiedLegalOrganizationXml = $this->specifiedLegalOrganization->toXML($document);

            if ($specifiedLegalOrganizationXml instanceof \DOMElement) {
                $currentNode->appendChild($specifiedLegalOrganizationXml);
            }
        }

        if ($this->definedTradeContact instanceof DefinedTradeContact) {
            $definedTradeContactXml = $this->definedTradeContact->toXML($document);

            if ($definedTradeContactXml instanceof \DOMElement) {
                $currentNode->appendChild($definedTradeContactXml);
            }
        }

        $currentNode->appendChild($this->postalTradeAddress->toXML($document));

        if ($this->URIUniversalCommunication instanceof URIUniversalCommunication) {
            $currentNode->appendChild($this->URIUniversalCommunication->toXML($document));
        }

        if ($this->specifiedTaxRegistrationVA instanceof SpecifiedTaxRegistrationVA) {
            $currentNode->appendChild($this->specifiedTaxRegistrationVA->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
    {
        $buyerTradePartyElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $buyerTradePartyElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $buyerTradePartyElement */
        $buyerTradePartyElement = $buyerTradePartyElements->item(0);

        $identifierElements = $xpath->query('./ram:ID', $buyerTradePartyElement);
        $nameElements       = $xpath->query('./ram:Name', $buyerTradePartyElement);

        if ($identifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $globalIdentifier           = BuyerGlobalIdentifier::fromXML($xpath, $buyerTradePartyElement);
        $specifiedLegalOrganization = BuyerSpecifiedLegalOrganization::fromXML($xpath, $buyerTradePartyElement);
        $definedTradeContact        = DefinedTradeContact::fromXML($xpath, $buyerTradePartyElement);
        $postalTradeAddress         = PostalTradeAddress::fromXML($xpath, $buyerTradePartyElement);
        $URIUniversalCommunication  = URIUniversalCommunication::fromXML($xpath, $buyerTradePartyElement);
        $specifiedTaxRegistrationVA = SpecifiedTaxRegistrationVA::fromXML($xpath, $buyerTradePartyElement);

        if (!$postalTradeAddress instanceof PostalTradeAddress) {
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

        if ($definedTradeContact instanceof DefinedTradeContact) {
            $buyerTradeParty->setDefinedTradeContact($definedTradeContact);
        }

        if ($URIUniversalCommunication instanceof URIUniversalCommunication) {
            $buyerTradeParty->setURIUniversalCommunication($URIUniversalCommunication);
        }

        if ($specifiedTaxRegistrationVA instanceof SpecifiedTaxRegistrationVA) {
            $buyerTradeParty->setSpecifiedTaxRegistrationVA($specifiedTaxRegistrationVA);
        }

        return $buyerTradeParty;
    }
}
