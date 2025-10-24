<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Flux1;

use Tiime\CrossIndustryInvoice\DataType\ActualDeliverySupplyChainEvent;
use Tiime\CrossIndustryInvoice\DataType\ShipToTradeParty;
use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BG-13-00.
 */
class ApplicableHeaderTradeDelivery extends \Tiime\CrossIndustryInvoice\DataType\Minimum\ApplicableHeaderTradeDelivery
{
    /**
     * BG-13.
     */
    protected ?ShipToTradeParty $shipToTradeParty;

    /**
     * BT-72-00.
     */
    protected ?ActualDeliverySupplyChainEvent $actualDeliverySupplyChainEvent;

    public function __construct()
    {
        $this->shipToTradeParty               = null;
        $this->actualDeliverySupplyChainEvent = null;
    }

    public function getShipToTradeParty(): ?ShipToTradeParty
    {
        return $this->shipToTradeParty;
    }

    public function setShipToTradeParty(?ShipToTradeParty $shipToTradeParty): static
    {
        $this->shipToTradeParty = $shipToTradeParty;

        return $this;
    }

    public function getActualDeliverySupplyChainEvent(): ?ActualDeliverySupplyChainEvent
    {
        return $this->actualDeliverySupplyChainEvent;
    }

    public function setActualDeliverySupplyChainEvent(?ActualDeliverySupplyChainEvent $actualDeliverySupplyChainEvent): static
    {
        $this->actualDeliverySupplyChainEvent = $actualDeliverySupplyChainEvent;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        if ($this->shipToTradeParty instanceof ShipToTradeParty) {
            $shipToTradePartyXml = $this->shipToTradeParty->toXML($document);

            if ($shipToTradePartyXml instanceof \DOMElement) {
                $element->appendChild($shipToTradePartyXml);
            }
        }

        if ($this->actualDeliverySupplyChainEvent instanceof ActualDeliverySupplyChainEvent) {
            $element->appendChild($this->actualDeliverySupplyChainEvent->toXML($document));
        }

        return $element;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
    {
        $applicableHeaderTradeDeliveryElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeDeliveryElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeDeliveryElement */
        $applicableHeaderTradeDeliveryElement = $applicableHeaderTradeDeliveryElements->item(0);

        $shipToTradeParty               = ShipToTradeParty::fromXML($xpath, $applicableHeaderTradeDeliveryElement);
        $actualDeliverySupplyChainEvent = ActualDeliverySupplyChainEvent::fromXML($xpath, $applicableHeaderTradeDeliveryElement);

        $applicableHeaderTradeDelivery = new self();

        if ($shipToTradeParty instanceof ShipToTradeParty) {
            $applicableHeaderTradeDelivery->setShipToTradeParty($shipToTradeParty);
        }

        if ($actualDeliverySupplyChainEvent instanceof ActualDeliverySupplyChainEvent) {
            $applicableHeaderTradeDelivery->setActualDeliverySupplyChainEvent($actualDeliverySupplyChainEvent);
        }

        return $applicableHeaderTradeDelivery;
    }
}
