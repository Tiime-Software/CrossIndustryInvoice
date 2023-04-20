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
    /**
     * BT-61 & BT-61-1.
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
        $element = $document->createElement('ram:SpecifiedLegalOrganization');

        $idElement = $document->createElement('ram:ID', $this->identifier->value);

        if ($this->identifier->scheme instanceof InternationalCodeDesignator) {
            $idElement->setAttribute('schemeID', $this->identifier->scheme->value);
        }

        $element->appendChild($idElement);

        return $element;
    }
}
