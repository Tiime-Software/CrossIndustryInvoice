<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeAgreement;

use Tiime\EN16931\DataType\Reference\PurchaseOrderLineReference;

/**
 * BT-13-00.
 */
class BuyerOrderReferencedDocument
{
    /**
     * BT-132.
     */
    private ?PurchaseOrderLineReference $lineID;

    public function __construct()
    {
    }

    public function getLineID(): ?PurchaseOrderLineReference
    {
        return $this->lineID;
    }

    public function setLineID(?PurchaseOrderLineReference $lineID): void
    {
        $this->lineID = $lineID;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:BuyerOrderReferencedDocument');

        if ($this->lineID instanceof PurchaseOrderLineReference) {
            $element->appendChild($document->createElement('ram:LineID', $this->lineID->value));
        }

        return $element;
    }
}
