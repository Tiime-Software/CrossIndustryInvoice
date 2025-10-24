<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Flux1;

use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\IncludedSupplyChainTradeLineItem;
use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction extends \Tiime\CrossIndustryInvoice\DataType\Minimum\SupplyChainTradeTransaction
{
    /**
     * BG-25.
     *
     * @var array<int, IncludedSupplyChainTradeLineItem>
     */
    protected array $includedSupplyChainTradeLineItems;

    public function __construct(
        ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement,
        ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery,
        ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement,
        array $includedSupplyChainTradeLineItems,
    ) {
        foreach ($includedSupplyChainTradeLineItems as $includedSupplyChainTradeLineItem) {
            if (!$includedSupplyChainTradeLineItem instanceof IncludedSupplyChainTradeLineItem) {
                throw new \TypeError();
            }
        }

        parent::__construct($applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement);

        $this->includedSupplyChainTradeLineItems = $includedSupplyChainTradeLineItems;
    }

    public function getApplicableHeaderTradeAgreement(): ApplicableHeaderTradeAgreement
    {
        $applicableHeaderTradeAgreement = parent::getApplicableHeaderTradeAgreement();

        if (!$applicableHeaderTradeAgreement instanceof ApplicableHeaderTradeAgreement) {
            throw new \LogicException('Must be of type FLux1\\ApplicableHeaderTradeAgreement');
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
     * @return array<int, IncludedSupplyChainTradeLineItem>
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

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): self
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
