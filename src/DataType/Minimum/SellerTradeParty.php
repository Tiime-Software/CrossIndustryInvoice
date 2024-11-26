<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationVA;
use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BG-4.
 */
class SellerTradeParty
{
    protected const string XML_NODE = 'ram:SellerTradeParty';

    /**
     * BT-30-00.
     */
    protected ?SellerSpecifiedLegalOrganization $specifiedLegalOrganization;

    /**
     * BT-31-00.
     */
    protected ?SpecifiedTaxRegistrationVA $specifiedTaxRegistrationVA;

    /**
     * @param string             $name               - BT-27
     * @param PostalTradeAddress $postalTradeAddress - BG-5
     */
    public function __construct(
        protected string $name,
        protected PostalTradeAddress $postalTradeAddress,
    ) {
        $this->specifiedLegalOrganization = null;
        $this->specifiedTaxRegistrationVA = null;
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

    public function getSpecifiedTaxRegistrationVA(): ?SpecifiedTaxRegistrationVA
    {
        return $this->specifiedTaxRegistrationVA;
    }

    public function setSpecifiedTaxRegistrationVA(?SpecifiedTaxRegistrationVA $specifiedTaxRegistrationVA): static
    {
        $this->specifiedTaxRegistrationVA = $specifiedTaxRegistrationVA;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        if ($this->specifiedLegalOrganization instanceof SellerSpecifiedLegalOrganization) {
            $specifiedLegalOrganizationXml = $this->specifiedLegalOrganization->toXML($document);

            if ($specifiedLegalOrganizationXml instanceof \DOMElement) {
                $currentNode->appendChild($specifiedLegalOrganizationXml);
            }
        }

        $currentNode->appendChild($this->postalTradeAddress->toXML($document));

        if ($this->specifiedTaxRegistrationVA instanceof SpecifiedTaxRegistrationVA) {
            $currentNode->appendChild($this->specifiedTaxRegistrationVA->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
    {
        $sellerTradePartyElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $sellerTradePartyElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerTradePartyElement */
        $sellerTradePartyElement = $sellerTradePartyElements->item(0);

        $nameElements = $xpath->query('./ram:Name', $sellerTradePartyElement);

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $postalTradeAddress         = PostalTradeAddress::fromXML($xpath, $sellerTradePartyElement);
        $specifiedLegalOrganization = SellerSpecifiedLegalOrganization::fromXML($xpath, $sellerTradePartyElement);
        $specifiedTaxRegistrationVA = SpecifiedTaxRegistrationVA::fromXML($xpath, $sellerTradePartyElement);

        if (null === $postalTradeAddress) {
            throw new \Exception('Malformed');
        }

        $sellerTradeParty = new self($name, $postalTradeAddress);

        if ($specifiedLegalOrganization instanceof SellerSpecifiedLegalOrganization) {
            $sellerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        if ($specifiedTaxRegistrationVA instanceof SpecifiedTaxRegistrationVA) {
            $sellerTradeParty->setSpecifiedTaxRegistrationVA($specifiedTaxRegistrationVA);
        }

        return $sellerTradeParty;
    }
}
