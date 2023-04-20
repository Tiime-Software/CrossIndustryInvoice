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

    public function setShipToTradeParty(?ShipToTradeParty $shipToTradeParty): void
    {
        $this->shipToTradeParty = $shipToTradeParty;
    }

    public function getActualDeliverySupplyChainEvent(): ?ActualDeliverySupplyChainEvent
    {
        return $this->actualDeliverySupplyChainEvent;
    }

    public function setActualDeliverySupplyChainEvent(?ActualDeliverySupplyChainEvent $actualDeliverySupplyChainEvent): void
    {
        $this->actualDeliverySupplyChainEvent = $actualDeliverySupplyChainEvent;
    }

    public function getDespatchAdviceReferencedDocument(): ?DespatchAdviceReferencedDocument
    {
        return $this->despatchAdviceReferencedDocument;
    }

    public function setDespatchAdviceReferencedDocument(?DespatchAdviceReferencedDocument $despatchAdviceReferencedDocument): void
    {
        $this->despatchAdviceReferencedDocument = $despatchAdviceReferencedDocument;
    }

    public function getReceivingAdviceReferencedDocument(): ?ReceivingAdviceReferencedDocument
    {
        return $this->receivingAdviceReferencedDocument;
    }

    public function setReceivingAdviceReferencedDocument(?ReceivingAdviceReferencedDocument $receivingAdviceReferencedDocument): void
    {
        $this->receivingAdviceReferencedDocument = $receivingAdviceReferencedDocument;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ApplicableHeaderTradeDelivery');

        /*
        if ($this->shipToTradeParty instanceof ShipToTradeParty) {
            $element->appendChild($this->shipToTradeParty->toXML($document));
        }

        if ($this->actualDeliverySupplyChainEvent instanceof ActualDeliverySupplyChainEvent) {
            $element->appendChild($this->actualDeliverySupplyChainEvent->toXML($document));
        }

        if ($this->despatchAdviceReferencedDocument instanceof DespatchAdviceReferencedDocument) {
            $element->appendChild($this->despatchAdviceReferencedDocument->toXML($document));
        }

        if ($this->receivingAdviceReferencedDocument instanceof ReceivingAdviceReferencedDocument) {
            $element->appendChild($this->receivingAdviceReferencedDocument->toXML($document));
        }
        */

        return $element;
    }
}
