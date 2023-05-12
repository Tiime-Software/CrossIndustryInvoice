<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-30-00.
 */
class SellerSpecifiedLegalOrganization
{
    protected const XML_NODE = 'ram:SpecifiedLegalOrganization';

    /**
     * BT-30 & BT-30-1.
     */
    private ?LegalRegistrationIdentifier $identifier;

    public function __construct()
    {
        $this->identifier = null;
    }

    public function getIdentifier(): ?LegalRegistrationIdentifier
    {
        return $this->identifier;
    }

    public function setIdentifier(?LegalRegistrationIdentifier $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if (null !== $this->identifier) {
            $identifierElement = $document->createElement('ram:ID', $this->identifier->value);
            $identifierElement->setAttribute('schemeID', $this->identifier->scheme->value);

            $currentNode->appendChild($identifierElement);
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $specifiedLegalOrganizationElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $specifiedLegalOrganizationElements->count()) {
            return null;
        }

        if ($specifiedLegalOrganizationElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedLegalOrganizationElement */
        $specifiedLegalOrganizationElement = $specifiedLegalOrganizationElements->item(0);

        $identifierElements = $xpath->query('.//ram:ID', $specifiedLegalOrganizationElement);

        if ($identifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $sellerSpecifiedLegalOrganization = new self();

        if (1 === $identifierElements->count()) {
            /** @var \DOMElement $identifierItem */
            $identifierItem = $identifierElements->item(0);
            $identifier     = $identifierItem->nodeValue;

            $scheme = null;

            if ('' !== $identifierItem->getAttribute('schemeID')) {
                $scheme = InternationalCodeDesignator::tryFrom($identifierItem->getAttribute('schemeID'));

                if (!$scheme instanceof InternationalCodeDesignator) {
                    throw new \Exception('Wrong schemeID');
                }
            }

            $sellerSpecifiedLegalOrganization->setIdentifier(new LegalRegistrationIdentifier($identifier, $scheme));
        }

        return $sellerSpecifiedLegalOrganization;
    }
}
