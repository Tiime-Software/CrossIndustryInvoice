<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

/**
 * BG-13-00.
 */
class ApplicableHeaderTradeDelivery
{
    /**
     * BG-13.
     */
    private ShipToTradeParty $shipToTradeParty;

    /**
     * BT-72-00.
     */
    private ?ActualDeliverySupplyChainEvent $actualDeliverySupplyChainEvent;

    /**
     * BT-16-00.
     */
    private ?DespatchAdviceReferencedDocument $despatchAdviceReferencedDocument;
}
