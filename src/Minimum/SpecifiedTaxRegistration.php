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
    private string $schemeID;

    public function __construct(VatIdentifier $identifier)
    {
        $this->identifier = $identifier;
        $this->schemeID   = 'VA';
    }

    public function getIdentifier(): VatIdentifier
    {
        return $this->identifier;
    }

    public function getSchemeID(): string
    {
        return $this->schemeID;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedLegalOrganization');
        $element->appendChild(
            $document->createElement('ram:ID', $this->identifier->getValue())
                ->setAttribute('schemeID', $this->schemeID)
        );

        return $element;
    }
}
