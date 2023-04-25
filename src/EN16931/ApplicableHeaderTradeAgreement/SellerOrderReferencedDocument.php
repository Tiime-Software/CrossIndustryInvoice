<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;

use Tiime\EN16931\DataType\Reference\SalesOrderReference;

/**
 * BT-14-00.
 */
class SellerOrderReferencedDocument
{
    /**
     * BT-14.
     */
    private SalesOrderReference $issuerAssignedIdentifier;

    public function __construct(SalesOrderReference $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
    }

    public function getIssuerAssignedIdentifier(): SalesOrderReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function toXML(\DOMDocument $document)
    {
        $element = $document->createElement('ram:SellerOrderReferencedDocument');

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        return $element;
    }
}
