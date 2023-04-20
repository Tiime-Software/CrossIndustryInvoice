<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

/**
 * BT-30-00.
 */
class SellerSpecifiedLegalOrganization extends \Tiime\CrossIndustryInvoice\DataType\Minimum\SellerSpecifiedLegalOrganization
{
    /**
     * BT-28.
     */
    private ?string $tradingBusinessName;

    public function __construct()
    {
        parent::__construct();
        $this->tradingBusinessName = null;
    }

    public function getTradingBusinessName(): ?string
    {
        return $this->tradingBusinessName;
    }

    public function setTradingBusinessName(?string $tradingBusinessName): void
    {
        $this->tradingBusinessName = $tradingBusinessName;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:SpecifiedLegalOrganization');

        if (null !== $this->getIdentifier()) {
            $identifierElement = $document->createElement('ram:ID', $this->getIdentifier()->value);

            if (null !== $this->getIdentifier()->scheme) {
                $identifierElement->setAttribute('schemeID', $this->getIdentifier()->scheme->value);
            }

            $currentNode->appendChild($identifierElement);
        }

        if (null !== $this->tradingBusinessName) {
            $currentNode->appendChild($document->createElement('ram:TradingBusinessName', $this->tradingBusinessName));
        }

        return $currentNode;
    }
}
