<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-47-00.
 */
class BuyerSpecifiedLegalOrganization extends \Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization
{
    /**
     * BT-45.
     */
    private ?string $tradingBusinessName;

    public function __construct()
    {
        parent::__construct();

        $this->tradingBusinessName = null;
    }

    public function setTradingBusinessName(?string $tradingBusinessName): static
    {
        $this->tradingBusinessName = $tradingBusinessName;

        return $this;
    }

    public function getTradingBusinessName(): ?string
    {
        return $this->tradingBusinessName;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $identifierNode = $document->createElement('ram:ID', $this->getIdentifier()->value);

        if ($this->identifier->scheme instanceof InternationalCodeDesignator) {
            $identifierNode->setAttribute('schemeID', $this->identifier->scheme->value);
        }

        $currentNode->appendChild($identifierNode);

        if (\is_string($this->tradingBusinessName)) {
            $currentNode->appendChild($document->createElement('ram:TradingBusinessName', $this->tradingBusinessName));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $specifiedLegalOrganizationElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $specifiedLegalOrganizationElements->count()) {
            return null;
        }

        if ($specifiedLegalOrganizationElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedLegalOrganizationElement */
        $specifiedLegalOrganizationElement = $specifiedLegalOrganizationElements->item(0);

        $identifierElements          = $xpath->query('./ram:ID', $specifiedLegalOrganizationElement);
        $tradingBusinessNameElements = $xpath->query('./ram:TradingBusinessName', $specifiedLegalOrganizationElement);

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($tradingBusinessNameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $identifierItem */
        $identifierItem = $identifierElements->item(0);
        $identifier     = $identifierItem->nodeValue;

        $scheme = null;

        if ($identifierItem->hasAttribute('schemeID')) {
            $scheme = InternationalCodeDesignator::tryFrom($identifierItem->getAttribute('schemeID'));
        }

        if (!$scheme instanceof InternationalCodeDesignator) {
            throw new \Exception('Wrong schemeID');
        }

        $specifiedLegalOrganization = new self(new LegalRegistrationIdentifier($identifier, $scheme));

        if (1 === $tradingBusinessNameElements->count()) {
            $specifiedLegalOrganization->setTradingBusinessName($tradingBusinessNameElements->item(0)->nodeValue);
        }

        return $specifiedLegalOrganization;
    }
}
