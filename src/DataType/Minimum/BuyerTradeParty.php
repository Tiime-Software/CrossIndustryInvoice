<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

/**
 * BG-7.
 */
class BuyerTradeParty
{
    protected const XML_NODE = 'ram:BuyerTradeParty';

    /**
     * BT-44.
     */
    protected string $name;

    /**
     * BT-47-00.
     */
    protected ?BuyerSpecifiedLegalOrganization $specifiedLegalOrganization;

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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        if ($this->specifiedLegalOrganization instanceof BuyerSpecifiedLegalOrganization) {
            $currentNode->appendChild($this->specifiedLegalOrganization->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $buyerTradePartyElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $buyerTradePartyElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $buyerTradePartyElement */
        $buyerTradePartyElement = $buyerTradePartyElements->item(0);

        $nameElements = $xpath->query('.//ram:Name', $buyerTradePartyElement);

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $specifiedLegalOrganization = BuyerSpecifiedLegalOrganization::fromXML($xpath, $buyerTradePartyElement);

        $buyerTradeParty = new self($name);

        if ($specifiedLegalOrganization instanceof BuyerSpecifiedLegalOrganization) {
            $buyerTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        return $buyerTradeParty;
    }
}
