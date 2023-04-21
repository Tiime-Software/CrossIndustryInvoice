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
    private SalesOrderReference $issuerAssignedID;

    public function __construct(SalesOrderReference $issuerAssignedID)
    {
        $this->issuerAssignedID = $issuerAssignedID;
    }

    public function getIssuerAssignedID(): SalesOrderReference
    {
        return $this->issuerAssignedID;
    }

    public function toXML(\DOMDocument $document)
    {
        $element = $document->createElement('ram:SellerOrderReferencedDocument');

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedID->value));

        return $element;
    }
}
