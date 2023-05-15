<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ApplicableHeaderTradeDelivery;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction
{
    protected const XML_NODE = 'rsm:SupplyChainTradeTransaction';

    /**
     * BT-10-00.
     */
    private ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement;

    /**
     * BG-13-00.
     */
    private ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery;

    /**
     * BG-19.
     */
    private ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement;

    public function __construct(ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement, ApplicableHeaderTradeDelivery $applicableHeaderTradeDelivery, ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement)
    {
        $this->applicableHeaderTradeAgreement  = $applicableHeaderTradeAgreement;
        $this->applicableHeaderTradeDelivery   = $applicableHeaderTradeDelivery;
        $this->applicableHeaderTradeSettlement = $applicableHeaderTradeSettlement;
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

        $element->appendChild($this->applicableHeaderTradeAgreement->toXML($document));
        $element->appendChild($this->applicableHeaderTradeDelivery->toXML($document));
        $element->appendChild($this->applicableHeaderTradeSettlement->toXML($document));

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

        $applicableHeaderTradeAgreement  = ApplicableHeaderTradeAgreement::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeDelivery   = ApplicableHeaderTradeDelivery::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeSettlement = ApplicableHeaderTradeSettlement::fromXML($xpath, $supplyChainTradeTransactionElement);

        return new self($applicableHeaderTradeAgreement, $applicableHeaderTradeDelivery, $applicableHeaderTradeSettlement);
    }
}
