<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

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
            throw new \Exception('SupplyChainTradeTransaction should contain at least one IncludedSupplyChainTradeLineItem.');
        }

        foreach ($includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            if (!$includedSupplyChainTradeLineItem instanceof IncludedSupplyChainTradeLineItem) {
                throw new \TypeError();
            }
        }

        parent::__construct($applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement, $includedSupplyChainTradeLineItems);
    }

    public function getApplicableHeaderTradeAgreement(): ApplicableHeaderTradeAgreement
    {
        $applicableHeaderTradeAgreement = parent::getApplicableHeaderTradeAgreement();

        if (!$applicableHeaderTradeAgreement instanceof ApplicableHeaderTradeAgreement) {
            throw new \LogicException('Must be of type EN16931\\ApplicableHeaderTradeAgreement');
        }

        return $applicableHeaderTradeAgreement;
    }

    public function getApplicableHeaderTradeDelivery(): ApplicableHeaderTradeDelivery
    {
        $applicableHeaderTradeDelivery = parent::getApplicableHeaderTradeDelivery();

        if (!$applicableHeaderTradeDelivery instanceof ApplicableHeaderTradeDelivery) {
            throw new \LogicException('Must be of type EN16931\\ApplicableHeaderTradeDelivery');
        }

        return $applicableHeaderTradeDelivery;
    }

    public function getApplicableHeaderTradeSettlement(): ApplicableHeaderTradeSettlement
    {
        $applicableHeaderTradeSettlement = parent::getApplicableHeaderTradeSettlement();

        if (!$applicableHeaderTradeSettlement instanceof ApplicableHeaderTradeSettlement) {
            throw new \LogicException('Must be of type EN16931\\ApplicableHeaderTradeSettlement');
        }

        return $applicableHeaderTradeSettlement;
    }

    /**
     * @return non-empty-array<int, IncludedSupplyChainTradeLineItem>
     */
    public function getIncludedSupplyChainTradeLineItems(): array
    {
        $includedSupplyChainTradeLineItems = parent::getIncludedSupplyChainTradeLineItems();

        foreach ($includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            if (!$includedSupplyChainTradeLineItem instanceof IncludedSupplyChainTradeLineItem) {
                throw new \LogicException('Must be of type EN16931\\IncludedSupplyChainTradeLineItem');
            }
        }

        return $includedSupplyChainTradeLineItems;
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
}
