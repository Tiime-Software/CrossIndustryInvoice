<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\ActualDeliverySupplyChainEvent;
use Tiime\CrossIndustryInvoice\DataType\DespatchAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ShipToTradeParty;

/**
 * BG-13-00.
 */
class ApplicableHeaderTradeDelivery
{
    protected const XML_NODE = 'ram:ApplicableHeaderTradeDelivery';

    /**
     * BG-13.
     */
    private ?ShipToTradeParty $shipToTradeParty;

    /**
     * BT-72-00.
     */
    private ?ActualDeliverySupplyChainEvent $actualDeliverySupplyChainEvent;

    /**
     * BT-16-00.
     */
    private ?DespatchAdviceReferencedDocument $despatchAdviceReferencedDocument;

    public function __construct()
    {
        $this->shipToTradeParty                 = null;
        $this->actualDeliverySupplyChainEvent   = null;
        $this->despatchAdviceReferencedDocument = null;
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

    public function getDespatchAdviceReferencedDocument(): ?DespatchAdviceReferencedDocument
    {
        return $this->despatchAdviceReferencedDocument;
    }

    public function setDespatchAdviceReferencedDocument(?DespatchAdviceReferencedDocument $despatchAdviceReferencedDocument): static
    {
        $this->despatchAdviceReferencedDocument = $despatchAdviceReferencedDocument;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        if ($this->shipToTradeParty instanceof ShipToTradeParty) {
            $element->appendChild($this->shipToTradeParty->toXML($document));
        }

        if ($this->actualDeliverySupplyChainEvent instanceof ActualDeliverySupplyChainEvent) {
            $element->appendChild($this->actualDeliverySupplyChainEvent->toXML($document));
        }

        if ($this->despatchAdviceReferencedDocument instanceof DespatchAdviceReferencedDocument) {
            $element->appendChild($this->despatchAdviceReferencedDocument->toXML($document));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $applicableHeaderTradeDeliveryElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeDeliveryElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeDeliveryElement */
        $applicableHeaderTradeDeliveryElement = $applicableHeaderTradeDeliveryElements->item(0);

        $shipToTradeParty                 = ShipToTradeParty::fromXML($xpath, $applicableHeaderTradeDeliveryElement);
        $actualDeliverySupplyChainEvent   = ActualDeliverySupplyChainEvent::fromXML($xpath, $applicableHeaderTradeDeliveryElement);
        $despatchAdviceReferencedDocument = DespatchAdviceReferencedDocument::fromXML($xpath, $applicableHeaderTradeDeliveryElement);

        $applicableHeaderTradeDelivery = new self();

        if (null !== $shipToTradeParty) {
            $applicableHeaderTradeDelivery->setShipToTradeParty($shipToTradeParty);
        }

        if (null !== $actualDeliverySupplyChainEvent) {
            $applicableHeaderTradeDelivery->setActualDeliverySupplyChainEvent($actualDeliverySupplyChainEvent);
        }

        if (null !== $despatchAdviceReferencedDocument) {
            $applicableHeaderTradeDelivery->setDespatchAdviceReferencedDocument($despatchAdviceReferencedDocument);
        }

        return $applicableHeaderTradeDelivery;
    }
}
