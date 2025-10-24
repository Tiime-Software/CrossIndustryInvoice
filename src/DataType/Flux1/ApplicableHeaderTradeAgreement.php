<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Flux1;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\BuyerTradeParty;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerTradeParty;
use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BT-10-00.
 */
class ApplicableHeaderTradeAgreement extends \Tiime\CrossIndustryInvoice\DataType\Minimum\ApplicableHeaderTradeAgreement
{
    /**
     * BG-11.
     */
    protected ?SellerTaxRepresentativeTradeParty $sellerTaxRepresentativeTradeParty;

    public function __construct(SellerTradeParty $sellerTradeParty, BuyerTradeParty $buyerTradeParty)
    {
        parent::__construct($sellerTradeParty, $buyerTradeParty);

        $this->sellerTaxRepresentativeTradeParty = null;
    }

    public function getSellerTradeParty(): SellerTradeParty
    {
        $sellerTradeParty = parent::getSellerTradeParty();

        if (!$sellerTradeParty instanceof SellerTradeParty) {
            throw new \LogicException('Must be of type BasicWL\\SellerTradeParty');
        }

        return $sellerTradeParty;
    }

    public function getBuyerTradeParty(): BuyerTradeParty
    {
        $buyerTradeParty = parent::getBuyerTradeParty();

        if (!$buyerTradeParty instanceof BuyerTradeParty) {
            throw new \LogicException('Mst be of type BasicWL\\BuyerTradeParty');
        }

        return $buyerTradeParty;
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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->sellerTradeParty->toXML($document));
        $currentNode->appendChild($this->buyerTradeParty->toXML($document));

        if ($this->sellerTaxRepresentativeTradeParty instanceof SellerTaxRepresentativeTradeParty) {
            $currentNode->appendChild($this->sellerTaxRepresentativeTradeParty->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
    {
        $applicableHeaderTradeAgreementElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeAgreementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeAgreementElement */
        $applicableHeaderTradeAgreementElement = $applicableHeaderTradeAgreementElements->item(0);

        $sellerTradeParty                  = SellerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $buyerTradeParty                   = BuyerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $sellerTaxRepresentativeTradeParty = SellerTaxRepresentativeTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);

        $applicableHeaderTradeAgreement = new self($sellerTradeParty, $buyerTradeParty);

        if ($sellerTaxRepresentativeTradeParty instanceof SellerTaxRepresentativeTradeParty) {
            $applicableHeaderTradeAgreement->setSellerTaxRepresentativeTradeParty($sellerTaxRepresentativeTradeParty);
        }

        return $applicableHeaderTradeAgreement;
    }
}
