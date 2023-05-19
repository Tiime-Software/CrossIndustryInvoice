<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\SellerGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\URIUniversalCommunication;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\DefinedTradeContact;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\SpecifiedTaxRegistration;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\SpecifiedTaxRegistration as SellerSpecifiedTaxRegistration;
use Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty\SpecifiedTaxRegistrationVAT;
use Tiime\EN16931\BusinessTermsGroup\Seller;
use Tiime\EN16931\BusinessTermsGroup\SellerContact;
use Tiime\EN16931\DataType\Identifier\SellerIdentifier;
use Tiime\EN16931\DataType\Identifier\TaxRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BG-4.
 */
class SellerTradeParty
{
    protected const XML_NODE = 'ram:SellerTradeParty';

    /**
     * BT-29.
     *
     * @var array<int, SellerIdentifier>
     */
    private array $identifiers;

    /**
     * BT-29-0 & BT-29-1.
     *
     * @var array<int, SellerGlobalIdentifier>
     */
    private array $globalIdentifiers;

    /**
     * BT-27.
     */
    private string $name;

    /**
     * BT-33.
     */
    private ?string $description;

    /**
     * BT-30-00.
     */
    private ?SellerSpecifiedLegalOrganization $specifiedLegalOrganization;

    /**
     * BG-6.
     */
    private ?DefinedTradeContact $definedTradeContact;

    /**
     * BG-5.
     */
    private PostalTradeAddress $postalTradeAddress;

    /**
     * BT-34-00.
     */
    private ?URIUniversalCommunication $uriUniversalCommunication;

    /**
     * BT-31-00.
     */
    private ?SpecifiedTaxRegistrationVAT $specifiedTaxRegistrationVAT;

    /**
     * BT-32-00.
     */
    private ?SpecifiedTaxRegistration $specifiedTaxRegistration;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        $this->name                        = $name;
        $this->postalTradeAddress          = $postalTradeAddress;
        $this->identifiers                 = [];
        $this->globalIdentifiers           = [];
        $this->description                 = null;
        $this->specifiedLegalOrganization  = null;
        $this->definedTradeContact         = null;
        $this->uriUniversalCommunication   = null;
        $this->specifiedTaxRegistrationVAT = null;
        $this->specifiedTaxRegistration    = null;
    }

    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

    public function setIdentifiers(array $identifiers): static
    {
        $tmpIdentifiers = [];

        foreach ($identifiers as $identifier) {
            if (!$identifier instanceof SellerIdentifier) {
                throw new \TypeError();
            }

            $tmpIdentifiers[] = $identifier;
        }

        $this->identifiers = $tmpIdentifiers;

        return $this;
    }

    public function getGlobalIdentifiers(): array
    {
        return $this->globalIdentifiers;
    }

    public function setGlobalIdentifiers(array $globalIdentifiers): static
    {
        $tmpGlobalIdentifiers = [];

        foreach ($globalIdentifiers as $globalIdentifier) {
            if (!$globalIdentifier instanceof SellerGlobalIdentifier) {
                throw new \TypeError();
            }

            $tmpGlobalIdentifiers[] = $globalIdentifier;
        }

        $this->globalIdentifiers = $tmpGlobalIdentifiers;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getSpecifiedLegalOrganization(): ?SellerSpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?SellerSpecifiedLegalOrganization $specifiedLegalOrganization): static
    {
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

    public function getPostalTradeAddress(): PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function getUriUniversalCommunication(): ?URIUniversalCommunication
    {
        return $this->uriUniversalCommunication;
    }

    public function setUriUniversalCommunication(?URIUniversalCommunication $uriUniversalCommunication): static
    {
        $this->uriUniversalCommunication = $uriUniversalCommunication;

        return $this;
    }

    public function getSpecifiedTaxRegistrationVAT(): ?SpecifiedTaxRegistrationVAT
    {
        return $this->specifiedTaxRegistrationVAT;
    }

    public function setSpecifiedTaxRegistrationVAT(?SpecifiedTaxRegistrationVAT $specifiedTaxRegistrationVAT): static
    {
        $this->specifiedTaxRegistrationVAT = $specifiedTaxRegistrationVAT;

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

        if ($this->uriUniversalCommunication instanceof URIUniversalCommunication) {
            $currentNode->appendChild($this->uriUniversalCommunication->toXML($document));
        }

        if ($this->specifiedTaxRegistrationVAT instanceof SpecifiedTaxRegistrationVAT) {
            $currentNode->appendChild($this->specifiedTaxRegistrationVAT->toXML($document));
        }

        if ($this->specifiedTaxRegistration instanceof SpecifiedTaxRegistration) {
            $currentNode->appendChild($this->specifiedTaxRegistration->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $sellerTradePartyElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $sellerTradePartyElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerTradePartyElement */
        $sellerTradePartyElement = $sellerTradePartyElements->item(0);

        $identifierElements  = $xpath->query('.//ram:ID', $sellerTradePartyElement);
        $nameElements        = $xpath->query('.//ram:Name', $sellerTradePartyElement);
        $descriptionElements = $xpath->query('.//ram:Description', $sellerTradePartyElement);

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($descriptionElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $globalIdentifiers           = SellerGlobalIdentifier::fromXML($xpath, $sellerTradePartyElement);
        $specifiedLegalOrganization  = SellerSpecifiedLegalOrganization::fromXML($xpath, $sellerTradePartyElement);
        $definedTradeContact         = DefinedTradeContact::fromXML($xpath, $sellerTradePartyElement);
        $postalTradeAddress          = PostalTradeAddress::fromXML($xpath, $sellerTradePartyElement);
        $uriUniversalCommunication   = URIUniversalCommunication::fromXML($xpath, $sellerTradePartyElement);
        $specifiedTaxRegistrationVAT = SpecifiedTaxRegistrationVAT::fromXML($xpath, $sellerTradePartyElement);
        $specifiedTaxRegistration    = SpecifiedTaxRegistration::fromXML($xpath, $sellerTradePartyElement);

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

        if ($specifiedTaxRegistrationVAT instanceof SpecifiedTaxRegistrationVAT) {
            $sellerTradeParty->setSpecifiedTaxRegistrationVATs($specifiedTaxRegistrationVAT);
        }

        if ($specifiedTaxRegistration instanceof SpecifiedTaxRegistration) {
            $sellerTradeParty->setSpecifiedTaxRegistrations($specifiedTaxRegistration);
        }

        return $sellerTradeParty;
    }

    public static function fromEN16931(Seller $seller): static
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
            ->setSpecifiedTaxRegistrationVAT(
                $seller->getVatIdentifier() instanceof VatIdentifier
                    ? (new SpecifiedTaxRegistrationVAT())->setIdentifier($seller->getVatIdentifier())
                    : null
            )
            ->setSpecifiedTaxRegistration(
                $seller->getTaxRegistrationIdentifier() instanceof TaxRegistrationIdentifier
                    ? (new SellerSpecifiedTaxRegistration())->setIdentifier($seller->getTaxRegistrationIdentifier())
                    : null
            );
    }
}
