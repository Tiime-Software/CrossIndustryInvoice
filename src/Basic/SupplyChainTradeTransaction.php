<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\BasicWL\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\BasicWL\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\BasicWL\ApplicableHeaderTradeSettlement;

class SupplyChainTradeTransaction extends \Tiime\CrossIndustryInvoice\BasicWL\SupplyChainTradeTransaction
{
    protected const XML_NODE = 'rsm:SupplyChainTradeTransaction';

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
            throw new \Exception('Malformed');
        }

        $tmpIncludedSupplyChainTradeLineItems = [];

        foreach ($includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            if (!$includedSupplyChainTradeLineItem instanceof IncludedSupplyChainTradeLineItem) {
                throw new \TypeError();
            }

            $tmpIncludedSupplyChainTradeLineItems[] = $includedSupplyChainTradeLineItem;
        }

        $this->includedSupplyChainTradeLineItems = $tmpIncludedSupplyChainTradeLineItems;
    }

    /**
     * @return non-empty-array<int, IncludedSupplyChainTradeLineItem>
     */
    public function getIncludedSupplyChainTradeLineItems(): array
    {
        return $this->includedSupplyChainTradeLineItems;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        foreach ($this->includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            $element->appendChild($includedSupplyChainTradeLineItem->toXML($document));
        }

        $element->appendChild($this->getApplicableHeaderTradeAgreement()->toXML($document));
        $element->appendChild($this->getApplicableHeaderTradeDelivery()->toXML($document));
        $element->appendChild($this->getApplicableHeaderTradeSettlement()->toXML($document));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $supplyChainTradeTransactionElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $supplyChainTradeTransactionElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $supplyChainTradeTransactionElement */
        $supplyChainTradeTransactionElement = $supplyChainTradeTransactionElements->item(0);

        $includedSupplyChainTradeLineItems = IncludedSupplyChainTradeLineItem::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeAgreement    = ApplicableHeaderTradeAgreement::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeDelivery     = ApplicableHeaderTradeDelivery::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeSettlement   = ApplicableHeaderTradeSettlement::fromXML($xpath, $supplyChainTradeTransactionElement);

        return new self($includedSupplyChainTradeLineItems, $applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement);
    }
}
