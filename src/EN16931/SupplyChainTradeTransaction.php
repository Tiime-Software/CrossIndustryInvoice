<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\Invoice;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction
{
    protected const XML_NODE = 'ram:SupplyChainTradeTransaction';

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
        $element = $document->createElement(self::XML_NODE);

        foreach ($this->includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            $element->appendChild($includedSupplyChainTradeLineItem->toXML($document));
        }

        $element->appendChild($this->applicableHeaderTradeAgreement->toXML($document));
        $element->appendChild($this->applicableHeaderTradeDelivery->toXML($document));
        $element->appendChild($this->applicableHeaderTradeSettlement->toXML($document));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
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
  
    public static function fromEN16931(Invoice $invoice): static
    {
        $items = [];

        foreach ($invoice->getInvoiceLines() as $invoiceLine) {
            $items[] = IncludedSupplyChainTradeLineItem::fromEN16931($invoiceLine);
        }

        return new self(
            $items,
            ApplicableHeaderTradeAgreement::fromEN16931($invoice),
            ApplicableHeaderTradeDelivery::fromEN16931($invoice),
            ApplicableHeaderTradeSettlement::fromEN16931($invoice),
        );
    }
}
