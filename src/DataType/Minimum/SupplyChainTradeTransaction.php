<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction
{
    protected const string XML_NODE = 'rsm:SupplyChainTradeTransaction';

    /**
     * @param ApplicableHeaderTradeAgreement  $applicableHeaderTradeAgreement  - BG-10-00
     * @param ApplicableHeaderTradeDelivery   $applicableHeaderTradeDelivery   - BG-13-00
     * @param ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement - BG-19
     */
    public function __construct(
        protected ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement,
        protected ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery,
        protected ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement,
    ) {
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
        $currentNode = $document->createElement(self::XML_NODE);

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

        $applicableHeaderTradeAgreement  = ApplicableHeaderTradeAgreement::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeDelivery   = ApplicableHeaderTradeDelivery::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeSettlement = ApplicableHeaderTradeSettlement::fromXML($xpath, $supplyChainTradeTransactionElement);

        return new self($applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement);
    }
}
