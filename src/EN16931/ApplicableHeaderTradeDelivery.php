<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

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

    /**
     * BT-15-00.
     */
    private ?ReceivingAdviceReferencedDocument $receivingAdviceReferencedDocument;

    public function __construct()
    {
        $this->shipToTradeParty                  = null;
        $this->actualDeliverySupplyChainEvent    = null;
        $this->despatchAdviceReferencedDocument  = null;
        $this->receivingAdviceReferencedDocument = null;
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

    public function getReceivingAdviceReferencedDocument(): ?ReceivingAdviceReferencedDocument
    {
        return $this->receivingAdviceReferencedDocument;
    }

    public function setReceivingAdviceReferencedDocument(?ReceivingAdviceReferencedDocument $receivingAdviceReferencedDocument): static
    {
        $this->receivingAdviceReferencedDocument = $receivingAdviceReferencedDocument;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->shipToTradeParty instanceof ShipToTradeParty) {
            $currentNode->appendChild($this->shipToTradeParty->toXML($document));
        }

        if ($this->actualDeliverySupplyChainEvent instanceof ActualDeliverySupplyChainEvent) {
            $currentNode->appendChild($this->actualDeliverySupplyChainEvent->toXML($document));
        }

        if ($this->despatchAdviceReferencedDocument instanceof DespatchAdviceReferencedDocument) {
            $currentNode->appendChild($this->despatchAdviceReferencedDocument->toXML($document));
        }

        if ($this->receivingAdviceReferencedDocument instanceof ReceivingAdviceReferencedDocument) {
            $currentNode->appendChild($this->receivingAdviceReferencedDocument->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $applicableHeaderTradeDeliveryElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeDeliveryElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeDeliveryElement */
        $applicableHeaderTradeDeliveryElement = $applicableHeaderTradeDeliveryElements->item(0);

        $shipToTradeParty                  = ShipToTradeParty::fromXML($xpath, $applicableHeaderTradeDeliveryElement);
        $actualDeliverySupplyChainEvent    = ActualDeliverySupplyChainEvent::fromXML($xpath, $applicableHeaderTradeDeliveryElement);
        $despatchAdviceReferencedDocument  = DespatchAdviceReferencedDocument::fromXML($xpath, $applicableHeaderTradeDeliveryElement);
        $receivingAdviceReferencedDocument = ReceivingAdviceReferencedDocument::fromXML($xpath, $applicableHeaderTradeDeliveryElement);

        $applicableHeaderTradeDelivery = new self();

        if ($shipToTradeParty instanceof ShipToTradeParty) {
            $applicableHeaderTradeDelivery->setShipToTradeParty($shipToTradeParty);
        }

        if ($actualDeliverySupplyChainEvent instanceof ActualDeliverySupplyChainEvent) {
            $applicableHeaderTradeDelivery->setActualDeliverySupplyChainEvent($actualDeliverySupplyChainEvent);
        }

        if ($despatchAdviceReferencedDocument instanceof DespatchAdviceReferencedDocument) {
            $applicableHeaderTradeDelivery->setDespatchAdviceReferencedDocument($despatchAdviceReferencedDocument);
        }

        if ($receivingAdviceReferencedDocument instanceof ReceivingAdviceReferencedDocument) {
            $applicableHeaderTradeDelivery->setReceivingAdviceReferencedDocument($receivingAdviceReferencedDocument);
        }

        return $applicableHeaderTradeDelivery;
    }
}
