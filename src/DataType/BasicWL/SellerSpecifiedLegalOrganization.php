<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

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

    public function setTradingBusinessName(?string $tradingBusinessName): static
    {
        $this->tradingBusinessName = $tradingBusinessName;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->identifier instanceof LegalRegistrationIdentifier) {
            $identifierElement = $document->createElement('ram:ID', $this->identifier->value);

            if ($this->identifier->scheme instanceof InternationalCodeDesignator) {
                $identifierElement->setAttribute('schemeID', $this->identifier->scheme->value);
            }

            $currentNode->appendChild($identifierElement);
        }

        if (\is_string($this->tradingBusinessName)) {
            $currentNode->appendChild($document->createElement('ram:TradingBusinessName', $this->tradingBusinessName));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $sellerSpecifiedLegalOrganizationElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $sellerSpecifiedLegalOrganizationElements->count()) {
            return null;
        }

        if ($sellerSpecifiedLegalOrganizationElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $sellerSpecifiedLegalOrganizationElement */
        $sellerSpecifiedLegalOrganizationElement = $sellerSpecifiedLegalOrganizationElements->item(0);

        $identifierElements          = $xpath->query('./ram:ID', $sellerSpecifiedLegalOrganizationElement);
        $tradingBusinessNameElements = $xpath->query('./ram:TradingBusinessName', $sellerSpecifiedLegalOrganizationElement);

        if ($identifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($tradingBusinessNameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $sellerSpecifiedLegalOrganization = new self();

        if (1 === $identifierElements->count()) {
            /** @var \DOMElement $identifierItem */
            $identifierItem = $identifierElements->item(0);
            $identifier     = $identifierItem->nodeValue;

            $scheme = null;

            if ($identifierItem->hasAttribute('schemeID')) {
                $scheme = InternationalCodeDesignator::tryFrom($identifierItem->getAttribute('schemeID'));

                if (!$scheme instanceof InternationalCodeDesignator) {
                    throw new \Exception('Wrong schemeID');
                }
            }

            $sellerSpecifiedLegalOrganization->setIdentifier(new LegalRegistrationIdentifier($identifier, $scheme));
        }

        if (1 === $tradingBusinessNameElements->count()) {
            $sellerSpecifiedLegalOrganization->setTradingBusinessName($tradingBusinessNameElements->item(0)->nodeValue);
        }

        return $sellerSpecifiedLegalOrganization;
    }
}
