<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Flux1;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BG-13.
 */
class ShipToTradeParty
{
    protected const string XML_NODE = 'ram:ShipToTradeParty';

    /**
     * BG-15.
     */
    private ?PostalTradeAddress $postalTradeAddress;

    public function __construct()
    {
        $this->postalTradeAddress = null;
    }

    public function getPostalTradeAddress(): ?PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function setPostalTradeAddress(?PostalTradeAddress $postalTradeAddress): static
    {
        $this->postalTradeAddress = $postalTradeAddress;

        return $this;
    }

    public function toXML(\DOMDocument $document): ?\DOMElement
    {
        if (null === $this->postalTradeAddress) {
            return null;
        }

        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($this->postalTradeAddress->toXML($document));

        return $element;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): ?self
    {
        $shipToTradePartyElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $shipToTradePartyElements->count()) {
            return null;
        }

        if ($shipToTradePartyElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $shipToTradePartyElement */
        $shipToTradePartyElement = $shipToTradePartyElements->item(0);
        $postalTradeAddress      = PostalTradeAddress::fromXML($xpath, $shipToTradePartyElement);

        $shipToTradeParty = new self();

        if ($postalTradeAddress instanceof PostalTradeAddress) {
            $shipToTradeParty->setPostalTradeAddress($postalTradeAddress);
        }

        return $shipToTradeParty;
    }
}
