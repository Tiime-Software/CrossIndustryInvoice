<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

/**
 * BG-25-00.
 */
class SupplyChainTradeTransaction
{
    /**
     * BG-10-00.
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

    public function __construct(
        ApplicableHeaderTradeAgreement $applicableHeaderTradeAgreement,
        ApplicableHeaderTradeSettlement $applicableHeaderTradeSettlement
    ) {
        $this->applicableHeaderTradeDelivery   = new ApplicableHeaderTradeDelivery();
        $this->applicableHeaderTradeAgreement  = $applicableHeaderTradeAgreement;
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
        $currentNode = $document->createElement('rsm:SupplyChainTradeTransaction');
        $currentNode->appendChild($this->applicableHeaderTradeAgreement->toXML($document));
        $currentNode->appendChild($this->applicableHeaderTradeDelivery->toXML($document));
        $currentNode->appendChild($this->applicableHeaderTradeSettlement->toXML($document));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $supplyChainTradeTransactionElements = $xpath->query('//rsm:SupplyChainTradeTransaction', $currentElement);

        if (1 !== $supplyChainTradeTransactionElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $supplyChainTradeTransactionElement */
        $supplyChainTradeTransactionElement = $supplyChainTradeTransactionElements->item(0);

        // The "ApplicableHeaderTradeDelivery" element is checked to make sure it is present, because it's not in the
        // constructor (empty object for Minimum profile), we will do nothing with it
        $applicableHeaderTradeDelivery   = ApplicableHeaderTradeDelivery::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeAgreement  = ApplicableHeaderTradeAgreement::fromXML($xpath, $supplyChainTradeTransactionElement);
        $applicableHeaderTradeSettlement = ApplicableHeaderTradeSettlement::fromXML($xpath, $supplyChainTradeTransactionElement);

        return new static($applicableHeaderTradeAgreement, $applicableHeaderTradeSettlement);
    }
}
