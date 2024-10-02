<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\EN16931\Invoice;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction extends \Tiime\CrossIndustryInvoice\DataType\Basic\SupplyChainTradeTransaction
{
    public function __construct(
        ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement,
        ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery,
        ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement,
        array $includedSupplyChainTradeLineItems,
    ) {
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

        if (0 === \count($tmpIncludedSupplyChainTradeLineItems)) {
            throw new \Exception('SupplyChainTradeTransaction should contain at least one IncludedSupplyChainTradeLineItem.');
        }

        parent::__construct($applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement, $includedSupplyChainTradeLineItems);
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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $supplyChainTradeTransactionElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $supplyChainTradeTransactionElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $supplyChainTradeTransactionElement */
        $supplyChainTradeTransactionElement = $supplyChainTradeTransactionElements->item(0);

        $includedSupplyChainTradeLineItems = IncludedSupplyChainTradeLineItem::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeAgreement    = ApplicableHeaderTradeAgreement::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeDelivery     = ApplicableHeaderTradeDelivery::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeSettlement   = ApplicableHeaderTradeSettlement::fromXML($xpath, $supplyChainTradeTransactionElement);

        return new self($applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement, $includedSupplyChainTradeLineItems);
    }

    public static function fromEN16931(Invoice $invoice): self
    {
        $items = [];

        foreach ($invoice->getInvoiceLines() as $invoiceLine) {
            $items[] = IncludedSupplyChainTradeLineItem::fromEN16931($invoiceLine);
        }

        return new self(
            ApplicableHeaderTradeAgreement::fromEN16931($invoice),
            ApplicableHeaderTradeDelivery::fromEN16931($invoice),
            ApplicableHeaderTradeSettlement::fromEN16931($invoice),
            $items,
        );
    }
}
