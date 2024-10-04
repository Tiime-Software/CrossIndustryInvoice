<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction extends \Tiime\CrossIndustryInvoice\DataType\Minimum\SupplyChainTradeTransaction
{
    public function __construct(
        ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement,
        ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery,
        ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement,
    ) {
        parent::__construct($applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement);
    }

    public function getApplicableHeaderTradeAgreement(): ApplicableHeaderTradeAgreement
    {
        $applicableHeaderTradeAgreement = parent::getApplicableHeaderTradeAgreement();

        if (!$applicableHeaderTradeAgreement instanceof ApplicableHeaderTradeAgreement) {
            throw new \LogicException('Must be of type BasicWL\\ApplicableHeaderTradeAgreement');
        }

        return $applicableHeaderTradeAgreement;
    }

    public function getApplicableHeaderTradeDelivery(): ApplicableHeaderTradeDelivery
    {
        $applicableHeaderTradeDelivery = parent::getApplicableHeaderTradeDelivery();

        if (!$applicableHeaderTradeDelivery instanceof ApplicableHeaderTradeDelivery) {
            throw new \LogicException('Must be of type BasicWL\\ApplicableHeaderTradeDelivery');
        }

        return $applicableHeaderTradeDelivery;
    }

    public function getApplicableHeaderTradeSettlement(): ApplicableHeaderTradeSettlement
    {
        $applicableHeaderTradeSettlement = parent::getApplicableHeaderTradeSettlement();

        if (!$applicableHeaderTradeSettlement instanceof ApplicableHeaderTradeSettlement) {
            throw new \LogicException('Must be of type BasicWL\\ApplicableHeaderTradeSettlement');
        }

        return $applicableHeaderTradeSettlement;
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
