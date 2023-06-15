<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\BuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ContractReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\SellerTaxRepresentativeTradeParty;

/**
 * BT-10-00.
 */
class ApplicableHeaderTradeAgreement extends \Tiime\CrossIndustryInvoice\DataType\Minimum\ApplicableHeaderTradeAgreement
{
    /**
     * BG-11.
     */
    protected ?SellerTaxRepresentativeTradeParty $sellerTaxRepresentativeTradeParty;

    /**
     * BT-12-00.
     */
    protected ?ContractReferencedDocument $contractReferencedDocument;

    public function __construct(SellerTradeParty $sellerTradeParty, BuyerTradeParty $buyerTradeParty)
    {
        parent::__construct($sellerTradeParty, $buyerTradeParty);

        $this->sellerTaxRepresentativeTradeParty = null;
        $this->contractReferencedDocument        = null;
    }

    public function getSellerTaxRepresentativeTradeParty(): ?SellerTaxRepresentativeTradeParty
    {
        return $this->sellerTaxRepresentativeTradeParty;
    }

    public function setSellerTaxRepresentativeTradeParty(?SellerTaxRepresentativeTradeParty $sellerTaxRepresentativeTradeParty): static
    {
        $this->sellerTaxRepresentativeTradeParty = $sellerTaxRepresentativeTradeParty;

        return $this;
    }

    public function getContractReferencedDocument(): ?ContractReferencedDocument
    {
        return $this->contractReferencedDocument;
    }

    public function setContractReferencedDocument(?ContractReferencedDocument $contractReferencedDocument): static
    {
        $this->contractReferencedDocument = $contractReferencedDocument;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if (\is_string($this->buyerReference)) {
            $currentNode->appendChild($document->createElement('ram:BuyerReference', $this->buyerReference));
        }

        $currentNode->appendChild($this->sellerTradeParty->toXML($document));
        $currentNode->appendChild($this->buyerTradeParty->toXML($document));

        if ($this->sellerTaxRepresentativeTradeParty instanceof SellerTaxRepresentativeTradeParty) {
            $currentNode->appendChild($this->sellerTaxRepresentativeTradeParty->toXML($document));
        }

        if ($this->buyerOrderReferencedDocument instanceof BuyerOrderReferencedDocument) {
            $currentNode->appendChild($this->buyerOrderReferencedDocument->toXML($document));
        }

        if ($this->contractReferencedDocument instanceof ContractReferencedDocument) {
            $currentNode->appendChild($this->contractReferencedDocument->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $applicableHeaderTradeAgreementElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeAgreementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeAgreementElement */
        $applicableHeaderTradeAgreementElement = $applicableHeaderTradeAgreementElements->item(0);

        $buyerReferenceElements = $xpath->query('./ram:BuyerReference', $applicableHeaderTradeAgreementElement);

        if ($buyerReferenceElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $sellerTradeParty                  = SellerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $buyerTradeParty                   = BuyerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $sellerTaxRepresentativeTradeParty = SellerTaxRepresentativeTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $buyerOrderReferencedDocument      = BuyerOrderReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $contractReferencedDocument        = ContractReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);

        $applicableHeaderTradeAgreement = new self($sellerTradeParty, $buyerTradeParty);

        if (1 === $buyerReferenceElements->count()) {
            $applicableHeaderTradeAgreement->setBuyerReference($buyerReferenceElements->item(0)->nodeValue);
        }

        if ($sellerTaxRepresentativeTradeParty instanceof SellerTaxRepresentativeTradeParty) {
            $applicableHeaderTradeAgreement->setSellerTaxRepresentativeTradeParty($sellerTaxRepresentativeTradeParty);
        }

        if ($buyerOrderReferencedDocument instanceof BuyerOrderReferencedDocument) {
            $applicableHeaderTradeAgreement->setBuyerOrderReferencedDocument($buyerOrderReferencedDocument);
        }

        if ($contractReferencedDocument instanceof ContractReferencedDocument) {
            $applicableHeaderTradeAgreement->setContractReferencedDocument($contractReferencedDocument);
        }

        return $applicableHeaderTradeAgreement;
    }
}
