<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-31-00.
 */
class SpecifiedTaxRegistrationVAT
{
    /**
     * BT-31.
     */
    private ?VatIdentifier $identifier;

    /**
     * BT-31-0.
     */
    private string $schemeID;

    public function __construct()
    {
        $this->schemeID   = 'VA';
        $this->identifier = null;
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

    public function getSchemeID(): string
    {
        return $this->schemeID;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTaxRegistration');

        if ($this->identifier instanceof VatIdentifier) {
            $identifierElement = $document->createElement('ram:ID', $this->identifier->getValue());
            $identifierElement->setAttribute('schemeId', $this->getSchemeID());

            $element->appendChild($identifierElement);
        }

        return $element;
    }
}
