<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-47-00.
 */
class BuyerSpecifiedLegalOrganization
{
    /**
     * BT-47 & BT-47-1.
     */
    private LegalRegistrationIdentifier $identifier;

    public function __construct(LegalRegistrationIdentifier $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): ?LegalRegistrationIdentifier
    {
        return $this->identifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode    = $document->createElement('ram:SpecifiedLegalOrganization');
        $identifierNode = $document->createElement('ram:ID', $this->identifier->value);

        if (null !== $this->identifier->scheme) {
            $identifierNode->setAttribute('schemeID', $this->identifier->scheme->value);
        }
        $currentNode->appendChild($identifierNode);

        return $currentNode;
    }

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $identifierElements = $xpath->query('//ram:ID');

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $identifierItem */
        $identifierItem = $identifierElements->item(0);
        $identifier     = $identifierItem->nodeValue;
        $scheme         = '' !== $identifierItem->getAttribute('schemeID') ?
            InternationalCodeDesignator::tryFrom($identifierItem->getAttribute('schemeID')) : null;

        return new static(new LegalRegistrationIdentifier($identifier, $scheme));
    }
}
