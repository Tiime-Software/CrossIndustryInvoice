<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\BasicWL\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\BasicWL\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\BasicWL\ApplicableHeaderTradeSettlement;

class SupplyChainTradeTransaction extends \Tiime\CrossIndustryInvoice\BasicWL\SupplyChainTradeTransaction
{
    /**
     * BG-25.
     *
     * @var non-empty-array<int, IncludedSupplyChainTradeLineItem>
     */
    private array $includedSupplyChainTradeLineItems;

    /**
     * @param non-empty-array<int, IncludedSupplyChainTradeLineItem> $includedSupplyChainTradeLineItems
     */
    public function __construct(
        array $includedSupplyChainTradeLineItems,
        ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement,
        ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery,
        ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement
    ) {
        parent::__construct($applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement);

        if (0 === \count($includedSupplyChainTradeLineItems)) {
            throw new \TypeError();
        }

        foreach ($includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            if (!$includedSupplyChainTradeLineItem instanceof IncludedSupplyChainTradeLineItem) {
                throw new \TypeError();
            }

            $this->includedSupplyChainTradeLineItems[] = $includedSupplyChainTradeLineItem;
        }
    }

    /**
     * @return non-empty-array<int, IncludedSupplyChainTradeLineItem>
     */
    public function getIncludedSupplyChainTradeLineItems(): array
    {
        return $this->includedSupplyChainTradeLineItems;
    }

    /**
     * @param non-empty-array<int, IncludedSupplyChainTradeLineItem> $includedSupplyChainTradeLineItems
     */
    public function setIncludedSupplyChainTradeLineItems(array $includedSupplyChainTradeLineItems): static
    {
        $this->includedSupplyChainTradeLineItems = $includedSupplyChainTradeLineItems;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('rsm:SupplyChainTradeTransaction');

        foreach ($this->includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            $element->appendChild($includedSupplyChainTradeLineItem->toXML($document));
        }

        $element->appendChild($this->getApplicableHeaderTradeAgreement()->toXML($document));
        $element->appendChild($this->getApplicableHeaderTradeDelivery()->toXML($document));
        $element->appendChild($this->getApplicableHeaderTradeSettlement()->toXML($document));

        return $element;
    }
}