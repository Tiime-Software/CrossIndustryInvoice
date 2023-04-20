<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Reference\ContractReference;

/**
 * BT-12-00.
 */
class ContractReferencedDocument
{
    /**
     * BT-12.
     */
    private ContractReference $issuerAssignedID;

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:ContractReferencedDocument');
        $currentNode->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedID->value));

        return $currentNode;
    }
}
