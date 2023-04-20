<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction
{
    /**
     * BG-1.
     *
     * @var array<int, IncludedSupplyChainTradeLineItem>
     */
    private array $includedSupplyChainTradeLineItems;

    /**
     * BT-10-00.
     */
    private ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement;

    /**
     * BT-13-00.
     */
    private ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery;

    /**
     * BG-19.
     */
    private ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement;

    public function __construct(
        array $includedSupplyChainTradeLineItems,
        ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement,
        ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery,
        ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement
    ) {
        $tmpIncludedSupplyChainTradeLineItems = [];

        foreach ($includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            if (!$includedSupplyChainTradeLineItem instanceof IncludedSupplyChainTradeLineItem) {
                throw new \TypeError();
            }

            $tmpIncludedSupplyChainTradeLineItems[] = $includedSupplyChainTradeLineItem;
        }

        if (empty($tmpIncludedSupplyChainTradeLineItems)) {
            throw new \Exception('SupplyChainTradeTransaction should contain at least one IncludedSupplyChainTradeLineItem.');
        }

        $this->includedSupplyChainTradeLineItems = $tmpIncludedSupplyChainTradeLineItems;
        $this->applicableHeaderTradeAgreement    = $applicableHeaderTradeAgreement;
        $this->applicableHeaderTradeDelivery     = $applicableHeaderTradeDelivery;
        $this->applicableHeaderTradeSettlement   = $applicableHeaderTradeSettlement;
    }

    public function getIncludedSupplyChainTradeLineItems(): array
    {
        return $this->includedSupplyChainTradeLineItems;
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
        $element = $document->createElement('ram:SupplyChainTradeTransaction');

        foreach ($this->includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            $element->appendChild($includedSupplyChainTradeLineItem->toXML($document));
        }

        $element->appendChild($this->applicableHeaderTradeAgreement->toXML($document));
        $element->appendChild($this->applicableHeaderTradeDelivery->toXML($document));
        $element->appendChild($this->applicableHeaderTradeSettlement->toXML($document));

        return $element;
    }
}
