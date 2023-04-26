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

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $applicableHeaderTradeAgreementElements  = $xpath->query('//ram:ApplicableHeaderTradeAgreement');
        $applicableHeaderTradeDeliveryElements   = $xpath->query('//ram:ApplicableHeaderTradeDelivery');
        $applicableHeaderTradeSettlementElements = $xpath->query('//ram:ApplicableHeaderTradeSettlement');

        if (1 !== $applicableHeaderTradeAgreementElements->count()) {
            throw new \Exception('Malformed');
        }

        // The "ApplicableHeaderTradeDelivery" element is checked to make sure it is present, it is not converted
        // afterwards because it is not needed for the constructor (empty object)
        if (1 !== $applicableHeaderTradeDeliveryElements->count()) {
            throw new \Exception('Malformed');
        }

        if (1 !== $applicableHeaderTradeSettlementElements->count()) {
            throw new \Exception('Malformed');
        }

        $applicableHeaderTradeAgreementDocument = new \DOMDocument();
        $applicableHeaderTradeAgreementDocument->appendChild($applicableHeaderTradeAgreementDocument->importNode($applicableHeaderTradeAgreementElements->item(0), true));
        $applicableHeaderTradeAgreement = ApplicableHeaderTradeAgreement::fromXML($applicableHeaderTradeAgreementDocument);

        $applicableHeaderTradeSettlementDocument = new \DOMDocument();
        $applicableHeaderTradeSettlementDocument->appendChild($applicableHeaderTradeSettlementDocument->importNode($applicableHeaderTradeSettlementElements->item(0), true));
        $applicableHeaderTradeSettlement = ApplicableHeaderTradeSettlement::fromXML($applicableHeaderTradeSettlementDocument);

        return new static($applicableHeaderTradeAgreement, $applicableHeaderTradeSettlement);
    }
}
