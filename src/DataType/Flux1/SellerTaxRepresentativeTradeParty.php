<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Flux1;

use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationVA;
use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BG-11.
 */
class SellerTaxRepresentativeTradeParty
{
    protected const string XML_NODE = 'ram:SellerTaxRepresentativeTradeParty';

    /**
     * @param SpecifiedTaxRegistrationVA $specifiedTaxRegistrationVA - BT-63-00
     */
    public function __construct(
        private readonly SpecifiedTaxRegistrationVA $specifiedTaxRegistrationVA,
    ) {
    }

    public function getSpecifiedTaxRegistrationVA(): SpecifiedTaxRegistrationVA
    {
        return $this->specifiedTaxRegistrationVA;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->specifiedTaxRegistrationVA->toXML($document));

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): ?self
    {
        $sellerTaxRepresentativeTradePartyElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $sellerTaxRepresentativeTradePartyElements->count()) {
            return null;
        }

        if ($sellerTaxRepresentativeTradePartyElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerTaxRepresentativeTradePartyElement */
        $sellerTaxRepresentativeTradePartyElement = $sellerTaxRepresentativeTradePartyElements->item(0);

        $specifiedTaxRegistrationVA = SpecifiedTaxRegistrationVA::fromXML($xpath, $sellerTaxRepresentativeTradePartyElement);

        if (!$specifiedTaxRegistrationVA instanceof SpecifiedTaxRegistrationVA) {
            throw new \Exception('Malformed');
        }

        return new self($specifiedTaxRegistrationVA);
    }
}
