<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\CrossIndustryInvoice\DataType\Minimum\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\Minimum\SellerSpecifiedLegalOrganization;

/**
 * BG-4.
 */
class SellerTradeParty
{
    /**
     * BT-27.
     */
    private string $name;

    /**
     * BT-30-00.
     */
    private ?SellerSpecifiedLegalOrganization $specifiedLegalOrganization;

    /**
     * BG-5.
     */
    private PostalTradeAddress $postalTradeAddress;

    /**
     * BT-31-00.
     *
     * @var array<int, SpecifiedTaxRegistration>
     */
    private array $specifiedTaxRegistrations;

    public function __construct(string $name, PostalTradeAddress $postalTradeAddress)
    {
        $this->name                       = $name;
        $this->postalTradeAddress         = $postalTradeAddress;
        $this->specifiedLegalOrganization = null;
        $this->specifiedTaxRegistrations  = [];
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getPostalTradeAddress(): PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function getSpecifiedTaxRegistrations(): array
    {
        return $this->specifiedTaxRegistrations;
    }

    public function setSpecifiedTaxRegistrations(array $specifiedTaxRegistrations): static
    {
        $this->specifiedTaxRegistrations = $specifiedTaxRegistrations;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:SellerTradeParty');
        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        if (null !== $this->specifiedLegalOrganization) {
            $currentNode->appendChild($this->specifiedLegalOrganization->toXML($document));
        }
        $currentNode->appendChild($this->postalTradeAddress->toXML($document));
        /** @var SpecifiedTaxRegistration $specifiedTaxRegistration */
        foreach ($this->specifiedTaxRegistrations as $specifiedTaxRegistration) {
            $currentNode->appendChild($specifiedTaxRegistration->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $nameElements                       = $xpath->query('//ram:Name');
        $specifiedLegalOrganizationElements = $xpath->query('//ram:SpecifiedLegalOrganization');
        $postalTradeAddressElements         = $xpath->query('//ram:PostalTradeAddress');
        $specifiedTaxRegistrationElements   = $xpath->query('//ram:SpecifiedLegalOrganization');

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($specifiedLegalOrganizationElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $postalTradeAddressElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $postalTradeAddressDocument = new \DOMDocument();
        $postalTradeAddressDocument->appendChild($postalTradeAddressDocument->importNode($postalTradeAddressElements->item(0), true));
        $postalTradeAddress = PostalTradeAddress::fromXML($postalTradeAddressDocument);

        $sellerTradeParty = new static($name, $postalTradeAddress);

        if (1 === $specifiedLegalOrganizationElements->count()) {
            $specifiedLegalOrganizationDocument = new \DOMDocument();
            $specifiedLegalOrganizationDocument->appendChild($specifiedLegalOrganizationDocument->importNode($specifiedLegalOrganizationElements->item(0), true));
            $specifiedLegalOrganization = SellerSpecifiedLegalOrganization::fromXML($specifiedLegalOrganizationDocument);

            $sellerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        $specifiedTaxRegistrations = [];

        foreach ($specifiedTaxRegistrationElements as $specifiedTaxRegistrationElement) {
            $specifiedTaxRegistrationDocument = new \DOMDocument();
            $specifiedTaxRegistrationDocument->appendChild($specifiedTaxRegistrationDocument->importNode($specifiedTaxRegistrationElement, true));
            $specifiedTaxRegistrations[] = SpecifiedTaxRegistration::fromXML($specifiedTaxRegistrationDocument);
        }

        if (\count($specifiedTaxRegistrations)) {
            $sellerTradeParty->setSpecifiedTaxRegistrations($specifiedTaxRegistrations);
        }

        return $sellerTradeParty;
    }
}
