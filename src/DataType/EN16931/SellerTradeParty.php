<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\DefinedTradeContact;
use Tiime\CrossIndustryInvoice\DataType\SellerGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationFC;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationVA;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\EN16931\BusinessTermsGroup\Seller;
use Tiime\EN16931\BusinessTermsGroup\SellerContact;
use Tiime\EN16931\DataType\Identifier\SellerIdentifier;
use Tiime\EN16931\DataType\Identifier\TaxRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BG-4.
 */
class SellerTradeParty extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerTradeParty
{
    /**
     * BT-33.
     */
    private ?string $description;

    /**
     * BG-6.
     */
    private ?DefinedTradeContact $definedTradeContact;

    /**
     * BT-32-00.
     */
    private ?SpecifiedTaxRegistrationFC $specifiedTaxRegistrationFC;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        parent::__construct($name, $postalTradeAddress);

        $this->description                = null;
        $this->definedTradeContact        = null;
        $this->specifiedTaxRegistrationFC = null;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getSpecifiedTaxRegistrationFC(): ?SpecifiedTaxRegistrationFC
    {
        return $this->specifiedTaxRegistrationFC;
    }

    public function setSpecifiedTaxRegistrationFC(?SpecifiedTaxRegistrationFC $specifiedTaxRegistrationFC): static
    {
        $this->specifiedTaxRegistrationFC = $specifiedTaxRegistrationFC;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        foreach ($this->identifiers as $identifier) {
            $currentNode->appendChild($document->createElement('ram:ID', $identifier->value));
        }

        foreach ($this->globalIdentifiers as $globalIdentifier) {
            $globalIdentifierElement = $document->createElement('ram:GlobalID', $globalIdentifier->value);
            $globalIdentifierElement->setAttribute('schemeID', $globalIdentifier->scheme->value);
            $currentNode->appendChild($globalIdentifierElement);
        }

        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        if (\is_string($this->description)) {
            $currentNode->appendChild($document->createElement('ram:Description', $this->description));
        }

        if ($this->specifiedLegalOrganization instanceof SellerSpecifiedLegalOrganization) {
            $currentNode->appendChild($this->specifiedLegalOrganization->toXML($document));
        }

        if ($this->definedTradeContact instanceof DefinedTradeContact) {
            $currentNode->appendChild($this->definedTradeContact->toXML($document));
        }

        $currentNode->appendChild($this->postalTradeAddress->toXML($document));

        if ($this->URIUniversalCommunication instanceof URIUniversalCommunication) {
            $currentNode->appendChild($this->URIUniversalCommunication->toXML($document));
        }

        if ($this->specifiedTaxRegistrationVA instanceof SpecifiedTaxRegistrationVA) {
            $currentNode->appendChild($this->specifiedTaxRegistrationVA->toXML($document));
        }

        if ($this->specifiedTaxRegistrationFC instanceof SpecifiedTaxRegistrationFC) {
            $currentNode->appendChild($this->specifiedTaxRegistrationFC->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $sellerTradePartyElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $sellerTradePartyElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerTradePartyElement */
        $sellerTradePartyElement = $sellerTradePartyElements->item(0);

        $identifierElements  = $xpath->query('./ram:ID', $sellerTradePartyElement);
        $nameElements        = $xpath->query('./ram:Name', $sellerTradePartyElement);
        $descriptionElements = $xpath->query('./ram:Description', $sellerTradePartyElement);

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($descriptionElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $globalIdentifiers          = SellerGlobalIdentifier::fromXML($xpath, $sellerTradePartyElement);
        $specifiedLegalOrganization = SellerSpecifiedLegalOrganization::fromXML($xpath, $sellerTradePartyElement);
        $definedTradeContact        = DefinedTradeContact::fromXML($xpath, $sellerTradePartyElement);
        $postalTradeAddress         = PostalTradeAddress::fromXML($xpath, $sellerTradePartyElement);
        $uriUniversalCommunication  = URIUniversalCommunication::fromXML($xpath, $sellerTradePartyElement);
        $specifiedTaxRegistrationVA = SpecifiedTaxRegistrationVA::fromXML($xpath, $sellerTradePartyElement);
        $specifiedTaxRegistrationFC = SpecifiedTaxRegistrationFC::fromXML($xpath, $sellerTradePartyElement);

        if (!$postalTradeAddress instanceof PostalTradeAddress) {
            throw new \Exception('Malformed');
        }

        $sellerTradeParty = new self($name, $postalTradeAddress);

        $identifiers = [];

        /** @var \DOMDocument $identifierElement */
        foreach ($identifierElements as $identifierElement) {
            $identifiers[] = new SellerIdentifier($identifierElement->nodeValue);
        }

        if (\count($identifiers) > 0) {
            $sellerTradeParty->setIdentifiers($identifiers);
        }

        if (\count($globalIdentifiers) > 0) {
            $sellerTradeParty->setGlobalIdentifiers($globalIdentifiers);
        }

        if (1 === $descriptionElements->count()) {
            $sellerTradeParty->setDescription($descriptionElements->item(0)->nodeValue);
        }

        if ($specifiedLegalOrganization instanceof SellerSpecifiedLegalOrganization) {
            $sellerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        if ($definedTradeContact instanceof DefinedTradeContact) {
            $sellerTradeParty->setDefinedTradeContact($definedTradeContact);
        }

        if ($uriUniversalCommunication instanceof URIUniversalCommunication) {
            $sellerTradeParty->setUriUniversalCommunication($uriUniversalCommunication);
        }

        if ($specifiedTaxRegistrationVA instanceof SpecifiedTaxRegistrationVA) {
            $sellerTradeParty->setSpecifiedTaxRegistrationVA($specifiedTaxRegistrationVA);
        }

        if ($specifiedTaxRegistrationFC instanceof SpecifiedTaxRegistrationFC) {
            $sellerTradeParty->setSpecifiedTaxRegistrationFC($specifiedTaxRegistrationFC);
        }

        return $sellerTradeParty;
    }

    public static function fromEN16931(Seller $seller): self
    {
        $identifiers       = [];
        $globalIdentifiers = [];

        foreach ($seller->getIdentifiers() as $identifier) {
            if ($identifier->scheme instanceof InternationalCodeDesignator) {
                $globalIdentifiers[] = new SellerGlobalIdentifier($identifier->value, $identifier->scheme);
            } else {
                $identifiers[] = $identifier;
            }
        }

        $sellerSpecifiedLegalOrganization = (new SellerSpecifiedLegalOrganization())
            ->setIdentifier($seller->getLegalRegistrationIdentifier())
            ->setTradingBusinessName($seller->getTradingName());

        return (new self($seller->getName(), PostalTradeAddress::fromEN16931($seller->getAddress())))
            ->setIdentifiers($identifiers)
            ->setGlobalIdentifiers($globalIdentifiers)
            ->setDescription($seller->getAdditionalLegalInformation())
            ->setSpecifiedLegalOrganization($sellerSpecifiedLegalOrganization)
            ->setDefinedTradeContact(
                $seller->getContact() instanceof SellerContact
                    ? DefinedTradeContact::fromEN16931($seller->getContact())
                    : null
            )
            ->setUriUniversalCommunication($seller->getElectronicAddress())
            ->setSpecifiedTaxRegistrationVA(
                $seller->getVatIdentifier() instanceof VatIdentifier
                    ? new SpecifiedTaxRegistrationVA($seller->getVatIdentifier())
                    : null
            )
            ->setSpecifiedTaxRegistrationFC(
                $seller->getTaxRegistrationIdentifier() instanceof TaxRegistrationIdentifier
                    ? new SpecifiedTaxRegistrationFC(new VatIdentifier($seller->getTaxRegistrationIdentifier()->value))
                    : null
            );
    }
}
