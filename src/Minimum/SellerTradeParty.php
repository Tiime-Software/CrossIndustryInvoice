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
        //todo $name
        $specifiedLegalOrganization = SellerSpecifiedLegalOrganization::fromXML($document);
        $postalTradeAddress = PostalTradeAddress::fromXML($document);
        //todo $specifiedTaxRegistrations

//        $sellerTradeParty = new static($postalTradeAddress);

//        if (null !== $specifiedLegalOrganization) {
//            $sellerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
//        }
    }
}
