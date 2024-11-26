<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\AdditionalReferencedDocumentAdditionalSupportingDocument;
use Tiime\CrossIndustryInvoice\DataType\AdditionalReferencedDocumentInvoicedObjectIdentifier;
use Tiime\CrossIndustryInvoice\DataType\AdditionalReferencedDocumentTenderOrLotReference;
use Tiime\CrossIndustryInvoice\DataType\BuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ContractReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\SellerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\SellerTaxRepresentativeTradeParty;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedProcuringProject;
use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BT-10-00.
 */
class ApplicableHeaderTradeAgreement extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeAgreement
{
    /**
     * BT-14-00.
     */
    private ?SellerOrderReferencedDocument $sellerOrderReferencedDocument;

    /**
     * BG-24.
     *
     * @var array<int, AdditionalReferencedDocumentAdditionalSupportingDocument>
     */
    private array $additionalReferencedDocuments;

    /**
     * BT-17-00.
     */
    private ?AdditionalReferencedDocumentTenderOrLotReference $additionalReferencedDocumentTenderOrLotReference;

    /**
     * BT-18-00.
     */
    private ?AdditionalReferencedDocumentInvoicedObjectIdentifier $additionalReferencedDocumentInvoicedObjectIdentifier;

    /**
     * BT-11-00.
     */
    private ?SpecifiedProcuringProject $specifiedProcuringProject;

    public function __construct(SellerTradeParty $sellerTradeParty, BuyerTradeParty $buyerTradeParty)
    {
        parent::__construct($sellerTradeParty, $buyerTradeParty);

        $this->additionalReferencedDocuments                        = [];
        $this->sellerOrderReferencedDocument                        = null;
        $this->specifiedProcuringProject                            = null;
        $this->additionalReferencedDocumentTenderOrLotReference     = null;
        $this->additionalReferencedDocumentInvoicedObjectIdentifier = null;
    }

    public function getSellerTradeParty(): SellerTradeParty
    {
        $sellerTradeParty = parent::getSellerTradeParty();

        if (!$sellerTradeParty instanceof SellerTradeParty) {
            throw new \LogicException('Must be of type EN16931\\SellerTradeParty');
        }

        return $sellerTradeParty;
    }

    public function getBuyerTradeParty(): BuyerTradeParty
    {
        $buyerTradeParty = parent::getBuyerTradeParty();

        if (!$buyerTradeParty instanceof BuyerTradeParty) {
            throw new \LogicException('Must be of type EN16931\\BuyerTradeParty');
        }

        return $buyerTradeParty;
    }

    public function getSellerOrderReferencedDocument(): ?SellerOrderReferencedDocument
    {
        return $this->sellerOrderReferencedDocument;
    }

    public function setSellerOrderReferencedDocument(?SellerOrderReferencedDocument $sellerOrderReferencedDocument): static
    {
        $this->sellerOrderReferencedDocument = $sellerOrderReferencedDocument;

        return $this;
    }

    /**
     * @return AdditionalReferencedDocumentAdditionalSupportingDocument[]
     */
    public function getAdditionalReferencedDocuments(): array
    {
        return $this->additionalReferencedDocuments;
    }

    public function setAdditionalReferencedDocuments(array $additionalReferencedDocuments): static
    {
        foreach ($additionalReferencedDocuments as $additionalReferencedDocument) {
            if (!$additionalReferencedDocument instanceof AdditionalReferencedDocumentAdditionalSupportingDocument) {
                throw new \TypeError();
            }
        }

        $this->additionalReferencedDocuments = $additionalReferencedDocuments;

        return $this;
    }

    public function getAdditionalReferencedDocumentTenderOrLotReference(): ?AdditionalReferencedDocumentTenderOrLotReference
    {
        return $this->additionalReferencedDocumentTenderOrLotReference;
    }

    public function setAdditionalReferencedDocumentTenderOrLotReference(?AdditionalReferencedDocumentTenderOrLotReference $additionalReferencedDocumentTenderOrLotReference): static
    {
        $this->additionalReferencedDocumentTenderOrLotReference = $additionalReferencedDocumentTenderOrLotReference;

        return $this;
    }

    public function getAdditionalReferencedDocumentInvoicedObjectIdentifier(): ?AdditionalReferencedDocumentInvoicedObjectIdentifier
    {
        return $this->additionalReferencedDocumentInvoicedObjectIdentifier;
    }

    public function setAdditionalReferencedDocumentInvoicedObjectIdentifier(?AdditionalReferencedDocumentInvoicedObjectIdentifier $additionalReferencedDocumentInvoicedObjectIdentifier): static
    {
        $this->additionalReferencedDocumentInvoicedObjectIdentifier = $additionalReferencedDocumentInvoicedObjectIdentifier;

        return $this;
    }

    public function getSpecifiedProcuringProject(): ?SpecifiedProcuringProject
    {
        return $this->specifiedProcuringProject;
    }

    public function setSpecifiedProcuringProject(?SpecifiedProcuringProject $specifiedProcuringProject): static
    {
        $this->specifiedProcuringProject = $specifiedProcuringProject;

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

        if ($this->sellerOrderReferencedDocument instanceof SellerOrderReferencedDocument) {
            $currentNode->appendChild($this->sellerOrderReferencedDocument->toXML($document));
        }

        if ($this->buyerOrderReferencedDocument instanceof BuyerOrderReferencedDocument) {
            $currentNode->appendChild($this->buyerOrderReferencedDocument->toXML($document));
        }

        if ($this->contractReferencedDocument instanceof ContractReferencedDocument) {
            $currentNode->appendChild($this->contractReferencedDocument->toXML($document));
        }

        foreach ($this->additionalReferencedDocuments as $additionalReferencedDocument) {
            $currentNode->appendChild($additionalReferencedDocument->toXML($document));
        }

        if ($this->additionalReferencedDocumentTenderOrLotReference instanceof AdditionalReferencedDocumentTenderOrLotReference) {
            $currentNode->appendChild($this->additionalReferencedDocumentTenderOrLotReference->toXML($document));
        }

        if ($this->additionalReferencedDocumentInvoicedObjectIdentifier instanceof AdditionalReferencedDocumentInvoicedObjectIdentifier) {
            $currentNode->appendChild($this->additionalReferencedDocumentInvoicedObjectIdentifier->toXML($document));
        }

        if ($this->specifiedProcuringProject instanceof SpecifiedProcuringProject) {
            $currentNode->appendChild($this->specifiedProcuringProject->toXML($document));
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

        $buyerReferenceElements = $xpath->query('./ram:BuyerReference', $applicableHeaderTradeAgreementElement);

        if ($buyerReferenceElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $sellerTradeParty                                     = SellerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $buyerTradeParty                                      = BuyerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $sellerTaxRepresentativeTradeParty                    = SellerTaxRepresentativeTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $sellerOrderReferencedDocument                        = SellerOrderReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $buyerOrderReferencedDocument                         = BuyerOrderReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $contractReferencedDocument                           = ContractReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $additionalReferencedDocuments                        = AdditionalReferencedDocumentAdditionalSupportingDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $additionalReferencedDocumentTenderOrLotReference     = AdditionalReferencedDocumentTenderOrLotReference::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $additionalReferencedDocumentInvoicedObjectIdentifier = AdditionalReferencedDocumentInvoicedObjectIdentifier::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $specifiedProcuringProject                            = SpecifiedProcuringProject::fromXML($xpath, $applicableHeaderTradeAgreementElement);

        $applicableHeaderTradeAgreement = new self($sellerTradeParty, $buyerTradeParty);

        if (1 === $buyerReferenceElements->count()) {
            $applicableHeaderTradeAgreement->setBuyerReference($buyerReferenceElements->item(0)->nodeValue);
        }

        if ($sellerTaxRepresentativeTradeParty instanceof SellerTaxRepresentativeTradeParty) {
            $applicableHeaderTradeAgreement->setSellerTaxRepresentativeTradeParty($sellerTaxRepresentativeTradeParty);
        }

        if ($sellerOrderReferencedDocument instanceof SellerOrderReferencedDocument) {
            $applicableHeaderTradeAgreement->setSellerOrderReferencedDocument($sellerOrderReferencedDocument);
        }

        if ($buyerOrderReferencedDocument instanceof BuyerOrderReferencedDocument) {
            $applicableHeaderTradeAgreement->setBuyerOrderReferencedDocument($buyerOrderReferencedDocument);
        }

        if ($contractReferencedDocument instanceof ContractReferencedDocument) {
            $applicableHeaderTradeAgreement->setContractReferencedDocument($contractReferencedDocument);
        }

        if (\count($additionalReferencedDocuments) > 0) {
            $applicableHeaderTradeAgreement->setAdditionalReferencedDocuments($additionalReferencedDocuments);
        }

        if ($additionalReferencedDocumentTenderOrLotReference instanceof AdditionalReferencedDocumentTenderOrLotReference) {
            $applicableHeaderTradeAgreement->setAdditionalReferencedDocumentTenderOrLotReference($additionalReferencedDocumentTenderOrLotReference);
        }

        if ($additionalReferencedDocumentInvoicedObjectIdentifier instanceof AdditionalReferencedDocumentInvoicedObjectIdentifier) {
            $applicableHeaderTradeAgreement->setAdditionalReferencedDocumentInvoicedObjectIdentifier($additionalReferencedDocumentInvoicedObjectIdentifier);
        }

        if ($specifiedProcuringProject instanceof SpecifiedProcuringProject) {
            $applicableHeaderTradeAgreement->setSpecifiedProcuringProject($specifiedProcuringProject);
        }

        return $applicableHeaderTradeAgreement;
    }
}
