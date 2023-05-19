<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\ActualDeliverySupplyChainEvent;
use Tiime\CrossIndustryInvoice\DataType\DespatchAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\OccurrenceDateTime;
use Tiime\CrossIndustryInvoice\DataType\ReceivingAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ShipToTradeParty;
use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;
use Tiime\EN16931\DataType\Reference\ReceivingAdviceReference;
use Tiime\EN16931\Invoice;

/**
 * BG-13-00.
 */
class ApplicableHeaderTradeDelivery extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeDelivery
{
    /**
     * BT-15-00.
     */
    private ?ReceivingAdviceReferencedDocument $receivingAdviceReferencedDocument;

    public function __construct()
    {
        parent::__construct();

        $this->receivingAdviceReferencedDocument = null;
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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
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

    public static function fromEN16931(Invoice $invoice): self
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
