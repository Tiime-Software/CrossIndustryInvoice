<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\Reference\ReceivingAdviceReference;

/**
 * BT-15-00.
 */
class ReceivingAdviceReferencedDocument
{
    /**
     * BT-15.
     */
    private ReceivingAdviceReference $issuerAssignedIdentifier;

    public function __construct(ReceivingAdviceReference $issuerAssignedIdentifier)
    {
        $this->$issuerAssignedIdentifier = $issuerAssignedIdentifier;
    }

    public function getIssuerAssignedIdentifier(): ReceivingAdviceReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:ReceivingAdviceReferencedDocument');

        $currentNode->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        return $currentNode;
    }
}
