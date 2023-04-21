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
        $this->additionalReferencedDocuments                        = [];
        $this->additionalReferencedDocumentTenderOrLotReference     = null;
        $this->additionalReferencedDocumentInvoicedObjectIdentifier = null;
    }

    public function getBuyerReference(): ?string
    {
        return $this->buyerReference;
    }

    public function setBuyerReference(?string $buyerReference): void
    {
        $this->buyerReference = $buyerReference;
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

    public function setSellerTaxRepresentativeTradeParty(?SellerTaxRepresentativeTradeParty $sellerTaxRepresentativeTradeParty): void
    {
        $this->sellerTaxRepresentativeTradeParty = $sellerTaxRepresentativeTradeParty;
    }

    public function getSellerOrderReferencedDocument(): ?SellerOrderReferencedDocument
    {
        return $this->sellerOrderReferencedDocument;
    }

    public function setSellerOrderReferencedDocument(?SellerOrderReferencedDocument $sellerOrderReferencedDocument): void
    {
        $this->sellerOrderReferencedDocument = $sellerOrderReferencedDocument;
    }

    public function getBuyerOrderReferencedDocument(): ?BuyerOrderReferencedDocument
    {
        return $this->buyerOrderReferencedDocument;
    }

    public function setBuyerOrderReferencedDocument(?BuyerOrderReferencedDocument $buyerOrderReferencedDocument): void
    {
        $this->buyerOrderReferencedDocument = $buyerOrderReferencedDocument;
    }

    public function getContractReferencedDocument(): ?ContractReferencedDocument
    {
        return $this->contractReferencedDocument;
    }

    public function setContractReferencedDocument(?ContractReferencedDocument $contractReferencedDocument): void
    {
        $this->contractReferencedDocument = $contractReferencedDocument;
    }

    public function getAdditionalReferencedDocuments(): array
    {
        return $this->additionalReferencedDocuments;
    }

    public function setAdditionalReferencedDocuments(array $additionalReferencedDocuments): void
    {
        $tmpAdditionalReferencedDocuments = [];

        foreach ($additionalReferencedDocuments as $additionalReferencedDocument) {
            if (!$additionalReferencedDocument instanceof AdditionalReferencedDocument) {
                throw new \TypeError();
            }
            $tmpAdditionalReferencedDocuments[] = $additionalReferencedDocument;
        }
        $this->additionalReferencedDocuments = $tmpAdditionalReferencedDocuments;
    }

    public function getSpecifiedProcuringProject(): ?SpecifiedProcuringProject
    {
        return $this->specifiedProcuringProject;
    }

    public function setSpecifiedProcuringProject(?SpecifiedProcuringProject $specifiedProcuringProject): void
    {
        $this->specifiedProcuringProject = $specifiedProcuringProject;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ApplicableHeaderTradeAgreement');

        if (\is_string($this->buyerReference)) {
            $element->appendChild($document->createElement('ram:BuyerReference', $this->buyerReference));
        }

        $element->appendChild($this->sellerTradeParty->toXML($document));
        $element->appendChild($this->buyerTradeParty->toXML($document));

        if ($this->sellerTaxRepresentativeTradeParty instanceof SellerTaxRepresentativeTradeParty) {
            $element->appendChild($this->sellerTaxRepresentativeTradeParty->toXML($document));
        }

        if ($this->sellerOrderReferencedDocument instanceof SellerOrderReferencedDocument) {
            $element->appendChild($this->sellerOrderReferencedDocument->toXML($document));
        }

        if ($this->buyerOrderReferencedDocument instanceof BuyerOrderReferencedDocument) {
            $element->appendChild($this->buyerOrderReferencedDocument->toXML($document));
        }

        if ($this->contractReferencedDocument instanceof ContractReferencedDocument) {
            $element->appendChild($this->contractReferencedDocument->toXML($document));
        }

        foreach ($this->additionalReferencedDocuments as $additionalReferencedDocument) {
            $element->appendChild($additionalReferencedDocument->toXML($document));
        }

        if ($this->additionalReferencedDocumentTenderOrLotReference instanceof AdditionalReferencedDocumentTenderOrLotReference) {
            $element->appendChild($this->additionalReferencedDocumentTenderOrLotReference->toXML($document));
        }

        if ($this->additionalReferencedDocumentInvoicedObjectIdentifier instanceof AdditionalReferencedDocumentInvoicedObjectIdentifier) {
            $element->appendChild($this->additionalReferencedDocumentInvoicedObjectIdentifier->toXML($document));
        }

        if ($this->specifiedProcuringProject instanceof SpecifiedProcuringProject) {
            $element->appendChild($this->specifiedProcuringProject->toXML($document));
        }

        return $element;
    }
}
