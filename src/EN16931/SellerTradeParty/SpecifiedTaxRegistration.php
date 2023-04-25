<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-32-00.
 */
class SpecifiedTaxRegistration
{
    /**
     * BT-32.
     */
    private ?VatIdentifier $identifier;

    /**
     * BT-32-0.
     */
    private string $schemeIdentifier;

    public function __construct()
    {
        $this->schemeIdentifier = 'FC';
        $this->identifier       = null;
    }

    public function getIdentifier(): ?VatIdentifier
    {
        return $this->identifier;
    }

    public function setIdentifier(?VatIdentifier $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getSchemeIdentifier(): string
    {
        return $this->schemeIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTaxRegistration');

        if ($this->identifier instanceof VatIdentifier) {
            $identifierElement = $document->createElement('ram:ID', $this->identifier->getValue());
            $identifierElement->setAttribute('schemeID', $this->schemeIdentifier);

            $element->appendChild($identifierElement);
        }

        return $element;
    }
}
