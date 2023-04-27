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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $sellerTradePartyElements = $xpath->query('.//ram:SellerTradeParty', $currentElement);

        if (1 !== $sellerTradePartyElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerTradePartyElement */
        $sellerTradePartyElement = $sellerTradePartyElements->item(0);

        $nameElements = $xpath->query('.//ram:Name', $sellerTradePartyElement);

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $postalTradeAddress         = PostalTradeAddress::fromXML($xpath, $sellerTradePartyElement);
        $specifiedLegalOrganization = SellerSpecifiedLegalOrganization::fromXML($xpath, $sellerTradePartyElement);
        $specifiedTaxRegistrations  = SpecifiedTaxRegistration::fromXML($xpath, $sellerTradePartyElement);

        $sellerTradeParty = new static($name, $postalTradeAddress);

        if (null !== $specifiedLegalOrganization) {
            $sellerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        if (\count($specifiedTaxRegistrations) > 0) {
            $sellerTradeParty->setSpecifiedTaxRegistrations($specifiedTaxRegistrations);
        }

        return $sellerTradeParty;
    }
}
