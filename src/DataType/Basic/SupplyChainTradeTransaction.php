<?php

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\IncludedSupplyChainTradeLineItem;
use Tiime\CrossIndustryInvoice\DataType\IncludedSupplyChainTradeLineItem as non;

class SupplyChainTradeTransaction extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\SupplyChainTradeTransaction
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
        if (0 === \count($includedSupplyChainTradeLineItems)) {
            throw new \Exception('Malformed');
        }

        $tmpIncludedSupplyChainTradeLineItems = [];

        foreach ($includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            if (!$includedSupplyChainTradeLineItem instanceof non) {
                throw new \TypeError();
            }

            $tmpIncludedSupplyChainTradeLineItems[] = $includedSupplyChainTradeLineItem;
        }

        parent::__construct($applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement);

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
        $currentNode = $document->createElement(self::XML_NODE);

        foreach ($this->includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            $currentNode->appendChild($includedSupplyChainTradeLineItem->toXML($document));
        }

        $currentNode->appendChild($this->applicableHeaderTradeAgreement->toXML($document));
        $currentNode->appendChild($this->applicableHeaderTradeDelivery->toXML($document));
        $currentNode->appendChild($this->applicableHeaderTradeSettlement->toXML($document));

        return $currentNode;
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
