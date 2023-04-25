<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-31-00.
 */
class SpecifiedTaxRegistration
{
    /**
     * BT-31.
     */
    private VatIdentifier $identifier;

    /**
     * BT-31-0.
     */
    private string $schemeIdentifier;

    public function __construct(VatIdentifier $identifier)
    {
        $this->identifier       = $identifier;
        $this->schemeIdentifier = 'VA';
    }

    public function getIdentifier(): VatIdentifier
    {
        return $this->identifier;
    }

    public function getSchemeIdentifier(): string
    {
        return $this->schemeIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:SpecifiedLegalOrganization');

        $identifierNode = $document->createElement('ram:ID', $this->identifier->getValue());
        $identifierNode->setAttribute('schemeID', $this->schemeIdentifier);
        $currentNode->appendChild($identifierNode);

        return $currentNode;
    }
}
