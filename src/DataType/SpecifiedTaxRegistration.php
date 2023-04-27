<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-48-00 or BT-63-00 or BT-31-00.
 */
class SpecifiedTaxRegistration
{
    /**
     * BT-48 or BT-63 or BT-31.
     */
    private VatIdentifier $identifier;

    /**
     * BT-48-0 or BT-63-0 or BT-31-0.
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
        $currentNode = $document->createElement('ram:SpecifiedTaxRegistration', $this->identifier->getValue());
        $currentNode->setAttribute('schemeID', $this->schemeIdentifier);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        // todo
    }
}
