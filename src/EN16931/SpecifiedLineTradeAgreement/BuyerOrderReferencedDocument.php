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
    private ?PurchaseOrderLineReference $lineIdentifier;

    public function __construct()
    {
    }

    /**
     * @return PurchaseOrderLineReference|null
     */
    public function getLineIdentifier(): ?PurchaseOrderLineReference
    {
        return $this->lineIdentifier;
    }

    /**
     * @param PurchaseOrderLineReference|null $lineIdentifier
     */
    public function setLineIdentifier(?PurchaseOrderLineReference $lineIdentifier): static
    {
        $this->lineIdentifier = $lineIdentifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:BuyerOrderReferencedDocument');

        if ($this->lineIdentifier instanceof PurchaseOrderLineReference) {
            $element->appendChild($document->createElement('ram:LineID', $this->lineIdentifier->value));
        }

        return $element;
    }
}
