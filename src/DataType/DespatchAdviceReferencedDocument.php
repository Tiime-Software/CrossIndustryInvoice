<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;

/**
 * BT-16-00.
 */
class DespatchAdviceReferencedDocument
{
    /**
     * BT-16.
     */
    private DespatchAdviceReference $issuerAssignedIdentifier;

    public function __construct(DespatchAdviceReference $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
    }

    public function getIssuerAssignedIdentifier(): DespatchAdviceReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:DespatchAdviceReferencedDocument');

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        return $element;
    }
}
