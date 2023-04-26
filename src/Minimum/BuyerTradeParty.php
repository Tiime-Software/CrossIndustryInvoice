<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization;

/**
 * BG-7.
 */
class BuyerTradeParty
{
    /**
     * BT-44.
     */
    private string $name;

    /**
     * BT-47-00.
     */
    private ?BuyerSpecifiedLegalOrganization $specifiedLegalOrganization;

    public function __construct(string $name)
    {
        $this->name                       = $name;
        $this->specifiedLegalOrganization = null;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:BuyerTradeParty');
        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        if (null !== $this->specifiedLegalOrganization) {
            $currentNode->appendChild($this->specifiedLegalOrganization->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $nameElements                       = $xpath->query('//ram:Name');
        $specifiedLegalOrganizationElements = $xpath->query('//ram:SpecifiedLegalOrganization');

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($specifiedLegalOrganizationElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $buyerTradeParty = new static($name);

        if (1 === $specifiedLegalOrganizationElements->count()) {
            $specifiedLegalOrganizationDocument = new \DOMDocument();
            $specifiedLegalOrganizationDocument->appendChild($specifiedLegalOrganizationDocument->importNode($specifiedLegalOrganizationElements->item(0), true));
            $specifiedLegalOrganization = BuyerSpecifiedLegalOrganization::fromXML($specifiedLegalOrganizationDocument);

            $buyerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        return $buyerTradeParty;
    }
}
