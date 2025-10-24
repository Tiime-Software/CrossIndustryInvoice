<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Flux1;

use Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\Minimum\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationVA;
use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\Codelist\CountryAlpha2Code;

/**
 * BG-7.
 */
class BuyerTradeParty
{
    protected const string XML_NODE = 'ram:BuyerTradeParty';

    /**
     * BT-47-00.
     */
    protected ?BuyerSpecifiedLegalOrganization $specifiedLegalOrganization;

    /**
     * BT-48-00.
     */
    protected ?SpecifiedTaxRegistrationVA $specifiedTaxRegistrationVA;

    /**
     * BG-5.
     */
    protected PostalTradeAddress $postalTradeAddress;

    public function __construct(CountryAlpha2Code $countryIdentifier)
    {
        $this->specifiedLegalOrganization = null;
        $this->specifiedTaxRegistrationVA = null;
        $this->postalTradeAddress         = new PostalTradeAddress($countryIdentifier);
    }

    public function getSpecifiedLegalOrganization(): ?BuyerSpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?BuyerSpecifiedLegalOrganization $specifiedLegalOrganization): static
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

        $currentNode->appendChild($this->postalTradeAddress->toXML($document));

        if ($this->specifiedLegalOrganization instanceof BuyerSpecifiedLegalOrganization) {
            $specifiedLegalOrganizationXml = $this->specifiedLegalOrganization->toXML($document);

            if ($specifiedLegalOrganizationXml instanceof \DOMElement) {
                $currentNode->appendChild($specifiedLegalOrganizationXml);
            }
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

        $postalTradeAddress = PostalTradeAddress::fromXML($xpath, $buyerTradePartyElement);

        if (null === $postalTradeAddress) {
            throw new \Exception('Malformed');
        }

        $specifiedTaxRegistrationVA = SpecifiedTaxRegistrationVA::fromXML($xpath, $buyerTradePartyElement);
        $specifiedLegalOrganization = BuyerSpecifiedLegalOrganization::fromXML($xpath, $buyerTradePartyElement);

        $buyerTradeParty = new self($postalTradeAddress->getCountryIdentifier());

        if ($specifiedLegalOrganization instanceof BuyerSpecifiedLegalOrganization) {
            $buyerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        if ($specifiedTaxRegistrationVA instanceof SpecifiedTaxRegistrationVA) {
            $buyerTradeParty->setSpecifiedTaxRegistrationVA($specifiedTaxRegistrationVA);
        }

        return $buyerTradeParty;
    }
}
