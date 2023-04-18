<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\BuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ContractReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\SellerTaxRepresentativeTradeParty;

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
     * BT-13-00.
     */
    private ?BuyerOrderReferencedDocument $buyerOrderReferencedDocument;

    /**
     * BT-12-00.
     */
    private ?ContractReferencedDocument $contractReferencedDocument;
}
