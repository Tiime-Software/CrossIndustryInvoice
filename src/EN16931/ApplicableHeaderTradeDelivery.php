<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\ActualDeliverySupplyChainEvent;
use Tiime\CrossIndustryInvoice\DataType\DespatchAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\OccurrenceDateTime;
use Tiime\CrossIndustryInvoice\DataType\ShipToTradeParty;
use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;
use Tiime\EN16931\DataType\Reference\ReceivingAdviceReference;
use Tiime\EN16931\Invoice;

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
        $currentNode = $document->createElement('ram:ApplicableHeaderTradeDelivery');

        if (null !== $this->shipToTradeParty) {
            $currentNode->appendChild($this->shipToTradeParty->toXML($document));
        }

        if (null !== $this->actualDeliverySupplyChainEvent) {
            $currentNode->appendChild($this->actualDeliverySupplyChainEvent->toXML($document));
        }

        if (null !== $this->despatchAdviceReferencedDocument) {
            $currentNode->appendChild($this->despatchAdviceReferencedDocument->toXML($document));
        }

        if (null !== $this->receivingAdviceReferencedDocument) {
            $currentNode->appendChild($this->receivingAdviceReferencedDocument->toXML($document));
        }

        return $currentNode;
    }

    public static function fromEN16931(Invoice $invoice): static
    {
        return (new self())
            ->setShipToTradeParty(ShipToTradeParty::fromEN16931($invoice->getDeliveryInformation()))
            ->setActualDeliverySupplyChainEvent(
                $invoice->getDeliveryInformation()->getActualDeliveryDate() instanceof \DateTimeInterface
                    ? new ActualDeliverySupplyChainEvent(new OccurrenceDateTime($invoice->getDeliveryInformation()->getActualDeliveryDate()))
                    : null
            )
            ->setDespatchAdviceReferencedDocument(
                $invoice->getDespatchAdviceReference() instanceof DespatchAdviceReference
                    ? new DespatchAdviceReferencedDocument($invoice->getDespatchAdviceReference())
                    : null
            )
            ->setReceivingAdviceReferencedDocument(
                $invoice->getReceivingAdviceReference() instanceof ReceivingAdviceReference
                    ? new ReceivingAdviceReferencedDocument($invoice->getReceivingAdviceReference())
                    : null
            );
    }
}
