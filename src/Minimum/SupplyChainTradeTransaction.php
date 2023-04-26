<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction
{
    /**
     * BG-10-00.
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

    public function __construct(
        ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement,
        ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement
    ) {
        $this->applicableHeaderTradeDelivery   = new ApplicableHeaderTradeDelivery();
        $this->applicableHeaderTradeAgreement  = $applicableHeaderTradeAgreement;
        $this->applicableHeaderTradeSettlement = $applicableHeaderTradeSettlement;
    }

    public function getApplicableHeaderTradeAgreement(): ApplicableHeaderTradeAgreement
    {
        return $this->applicableHeaderTradeAgreement;
    }

    public function getApplicableHeaderTradeDelivery(): ApplicableHeaderTradeDelivery
    {
        return $this->applicableHeaderTradeDelivery;
    }

    public function getApplicableHeaderTradeSettlement(): ApplicableHeaderTradeSettlement
    {
        return $this->applicableHeaderTradeSettlement;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('rsm:SupplyChainTradeTransaction');
        $currentNode->appendChild($this->applicableHeaderTradeAgreement->toXML($document));
        $currentNode->appendChild($this->applicableHeaderTradeDelivery->toXML($document));
        $currentNode->appendChild($this->applicableHeaderTradeSettlement->toXML($document));

        return $currentNode;
    }

    public static function fromXML(\DOMDocument $document): static
    {
        $applicableHeaderTradeAgreement = ApplicableHeaderTradeAgreement::fromXML($document);
        $applicableHeaderTradeSettlement  = ApplicableHeaderTradeSettlement::fromXML($document);

        return new static($applicableHeaderTradeAgreement, $applicableHeaderTradeSettlement);
    }
}
