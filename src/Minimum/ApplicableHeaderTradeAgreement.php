<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

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

    public function getBuyerOrderReferencedDocument(): BuyerOrderReferencedDocument
    {
        return $this->buyerOrderReferencedDocument;
    }
}
