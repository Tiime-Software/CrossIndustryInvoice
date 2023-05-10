<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\BuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ContractReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\SellerTaxRepresentativeTradeParty;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement\AdditionalReferencedDocument;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement\AdditionalReferencedDocumentInvoicedObjectIdentifier;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement\AdditionalReferencedDocumentTenderOrLotReference;
use Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement\SellerOrderReferencedDocument;

/**
 * BT-10-00.
 */
class ApplicableHeaderTradeAgreement
{
    protected const XML_NODE = 'ram:ApplicableHeaderTradeAgreement';

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
     * BG-11.
     */
    private ?SellerTaxRepresentativeTradeParty $sellerTaxRepresentativeTradeParty;

    /**
     * BT-14-00.
     */
    private ?SellerOrderReferencedDocument $sellerOrderReferencedDocument;

    /**
     * BT-13-00.
     */
    private ?BuyerOrderReferencedDocument $buyerOrderReferencedDocument;

    /**
     * BT-12-00.
     */
    private ?ContractReferencedDocument $contractReferencedDocument;

    /**
     * BG-24.
     *
     * @var array<int, AdditionalReferencedDocument>
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
        $this->sellerTradeParty                                     = $sellerTradeParty;
        $this->buyerTradeParty                                      = $buyerTradeParty;
        $this->buyerReference                                       = null;
        $this->sellerTaxRepresentativeTradeParty                    = null;
        $this->sellerOrderReferencedDocument                        = null;
        $this->buyerOrderReferencedDocument                         = null;
        $this->contractReferencedDocument                           = null;
        $this->specifiedProcuringProject                            = null;
        $this->additionalReferencedDocumentTenderOrLotReference     = null;
        $this->additionalReferencedDocumentInvoicedObjectIdentifier = null;
        $this->additionalReferencedDocuments                        = [];
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

    public function getSellerTaxRepresentativeTradeParty(): ?SellerTaxRepresentativeTradeParty
    {
        return $this->sellerTaxRepresentativeTradeParty;
    }

    public function setSellerTaxRepresentativeTradeParty(?SellerTaxRepresentativeTradeParty $sellerTaxRepresentativeTradeParty): static
    {
        $this->sellerTaxRepresentativeTradeParty = $sellerTaxRepresentativeTradeParty;

        return $this;
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

    public function getBuyerOrderReferencedDocument(): ?BuyerOrderReferencedDocument
    {
        return $this->buyerOrderReferencedDocument;
    }

    public function setBuyerOrderReferencedDocument(?BuyerOrderReferencedDocument $buyerOrderReferencedDocument): static
    {
        $this->buyerOrderReferencedDocument = $buyerOrderReferencedDocument;

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

    public function getAdditionalReferencedDocuments(): array
    {
        return $this->additionalReferencedDocuments;
    }

    public function setAdditionalReferencedDocuments(array $additionalReferencedDocuments): static
    {
        $tmpAdditionalReferencedDocuments = [];

        foreach ($additionalReferencedDocuments as $additionalReferencedDocument) {
            if (!$additionalReferencedDocument instanceof AdditionalReferencedDocument) {
                throw new \TypeError();
            }
            $tmpAdditionalReferencedDocuments[] = $additionalReferencedDocument;
        }

        $this->additionalReferencedDocuments = $tmpAdditionalReferencedDocuments;

        return $this;
    }


    /**
     * @return AdditionalReferencedDocumentTenderOrLotReference|null
     */
    public function getAdditionalReferencedDocumentTenderOrLotReference(): ?AdditionalReferencedDocumentTenderOrLotReference
    {
        return $this->additionalReferencedDocumentTenderOrLotReference;
    }

    /**
     * @param AdditionalReferencedDocumentTenderOrLotReference|null $additionalReferencedDocumentTenderOrLotReference
     */
    public function setAdditionalReferencedDocumentTenderOrLotReference(?AdditionalReferencedDocumentTenderOrLotReference $additionalReferencedDocumentTenderOrLotReference): void
    {
        $this->additionalReferencedDocumentTenderOrLotReference = $additionalReferencedDocumentTenderOrLotReference;
    }

    /**
     * @return AdditionalReferencedDocumentInvoicedObjectIdentifier|null
     */
    public function getAdditionalReferencedDocumentInvoicedObjectIdentifier(): ?AdditionalReferencedDocumentInvoicedObjectIdentifier
    {
        return $this->additionalReferencedDocumentInvoicedObjectIdentifier;
    }

    /**
     * @param AdditionalReferencedDocumentInvoicedObjectIdentifier|null $additionalReferencedDocumentInvoicedObjectIdentifier
     */
    public function setAdditionalReferencedDocumentInvoicedObjectIdentifier(?AdditionalReferencedDocumentInvoicedObjectIdentifier $additionalReferencedDocumentInvoicedObjectIdentifier): void
    {
        $this->additionalReferencedDocumentInvoicedObjectIdentifier = $additionalReferencedDocumentInvoicedObjectIdentifier;
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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $applicableHeaderTradeAgreementElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $applicableHeaderTradeAgreementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableHeaderTradeAgreementElement */
        $applicableHeaderTradeAgreementElement = $applicableHeaderTradeAgreementElements->item(0);

        $buyerReferenceElements = $xpath->query('.//ram:BuyerReference', $applicableHeaderTradeAgreementElement);

        if ($buyerReferenceElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $sellerTradeParty = SellerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $buyerTradeParty = BuyerTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $sellerTaxRepresentativeTradeParty = SellerTaxRepresentativeTradeParty::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $sellerOrderReferencedDocument = SellerOrderReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $buyerOrderReferencedDocument = BuyerOrderReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $contractReferencedDocument = ContractReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $additionalReferencedDocuments = AdditionalReferencedDocument::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $additionalReferencedDocumentTenderOrLotReference = AdditionalReferencedDocumentTenderOrLotReference::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $additionalReferencedDocumentInvoicedObjectIdentifier = AdditionalReferencedDocumentInvoicedObjectIdentifier::fromXML($xpath, $applicableHeaderTradeAgreementElement);
        $specifiedProcuringProject = SpecifiedProcuringProject::fromXML($xpath, $applicableHeaderTradeAgreementElement);

        $applicableHeaderTradeAgreement = new static($sellerTradeParty, $buyerTradeParty);

        if ($buyerReferenceElements->count() === 1) {
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

        if (count($additionalReferencedDocuments) > 0) {
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
