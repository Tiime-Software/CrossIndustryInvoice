<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction
{
    /**
     * BT-10-00.
     */
    private ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement;

    /**
     * BG-13-00.
     */
    private ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery;

    /**
     * BG-19.
     */
    private ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement;

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('rsm:SupplyChainTradeTransaction');

        $element->appendChild($this->applicableHeaderTradeAgreement->toXML($document));
        $element->appendChild($this->applicableHeaderTradeDelivery->toXML($document));
        $element->appendChild($this->applicableHeaderTradeSettlement->toXML($document));

        return $element;
    }
}
