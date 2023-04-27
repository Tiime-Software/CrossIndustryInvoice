<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\CrossIndustryInvoice\DataType\BuyerOrderReferencedDocument;

/**
 * BT-10-00.
 */
class ApplicableHeaderTradeAgreement
{
    /**
     * BT-10.
     */
    private ?string $buyerReference;

    /**
     * BG-4.
     */
    private SellerTradeParty $sellerTradeParty;

    /**
     * BG-7.
     */
    private BuyerTradeParty $buyerTradeParty;

    /**
     * BT-13-00.
     */
    private BuyerOrderReferencedDocument $buyerOrderReferencedDocument;

    public function __construct(
        SellerTradeParty $sellerTradeParty,
        BuyerTradeParty $buyerTradeParty,
        BuyerOrderReferencedDocument $buyerOrderReferencedDocument
    ) {
        $this->sellerTradeParty             = $sellerTradeParty;
        $this->buyerTradeParty              = $buyerTradeParty;
        $this->buyerOrderReferencedDocument = $buyerOrderReferencedDocument;
        $this->buyerReference               = null;
    }

    public function getBuyerReference(): ?string
    {
        return $this->buyerReference;
    }

    public function setBuyerReference(?string $buyerReference): static
    {
        $this->buyerReference = $buyerReference;

        return $this;
    }

    public function getSellerTradeParty(): SellerTradeParty
    {
        return $this->sellerTradeParty;
    }

    public function getBuyerTradeParty(): BuyerTradeParty
    {
        return $this->buyerTradeParty;
    }

    public function getBuyerOrderReferencedDocument(): BuyerOrderReferencedDocument
    {
        return $this->buyerOrderReferencedDocument;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:ApplicableHeaderTradeAgreement');

        if (null !== $this->buyerReference) {
            $currentNode->appendChild($document->createElement('ram:BuyerReference', $this->buyerReference));
        }
        $currentNode->appendChild($this->sellerTradeParty->toXML($document));
        $currentNode->appendChild($this->buyerTradeParty->toXML($document));
        $currentNode->appendChild($this->buyerOrderReferencedDocument->toXML($document));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $applicableHeaderTradeAgreementElements = $xpath->query('//ram:ApplicableHeaderTradeAgreement', $currentElement);

        if (1 !== $applicableHeaderTradeAgreementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeAgreementElement */
        $applicableHeaderTradeAgreementElement = $applicableHeaderTradeAgreementElements->item(0);

        $buyerReferenceElements = $xpath->query('//ram:BuyerReference', $applicableHeaderTradeAgreementElement);

        if ($buyerReferenceElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $sellerTradeParty             = SellerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $buyerTradeParty              = BuyerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $buyerOrderReferencedDocument = BuyerOrderReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);

        $applicableHeaderTradeAgreement = new static($sellerTradeParty, $buyerTradeParty, $buyerOrderReferencedDocument);

        if (1 === $buyerReferenceElements->count()) {
            $buyerReference = $buyerReferenceElements->item(0)->nodeValue;

            $applicableHeaderTradeAgreement->setBuyerReference($buyerReference);
        }

        return $applicableHeaderTradeAgreement;
    }
}
