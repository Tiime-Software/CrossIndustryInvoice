<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-61-00.
 */
class PayeeSpecifiedLegalOrganization
{
    protected const XML_NODE = 'ram:SpecifiedLegalOrganization';

    /**
     * BT-61 & BT-61-1.
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

    public function setIdentifier(?LegalRegistrationIdentifier $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        if ($this->identifier instanceof LegalRegistrationIdentifier) {
            $idElement = $document->createElement('ram:ID', $this->identifier->value);

            if ($this->identifier->scheme instanceof InternationalCodeDesignator) {
                $idElement->setAttribute('schemeID', $this->identifier->scheme->value);
            }

            $element->appendChild($idElement);
        }

        return $element;
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

        $identifierElements = $xpath->query('./ram:ID', $specifiedLegalOrganizationElement);

        if ($identifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $payeeSpecifiedLegalOrganization = new self();

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

            $payeeSpecifiedLegalOrganization->setIdentifier(new LegalRegistrationIdentifier($identifier, $scheme));
        }

        return $payeeSpecifiedLegalOrganization;
    }
}
