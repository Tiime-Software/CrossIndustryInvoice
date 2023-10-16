<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\EN16931\DataType\UnitOfMeasurement;
use Tiime\EN16931\SemanticDataType\Quantity;

/**
 * BT-129 & BT-130.
 */
class BilledQuantity
{
    protected const XML_NODE = 'ram:BilledQuantity';

    /**
     * BT-129.
     */
    private Quantity $quantity;

    /**
     * BT-130.
     */
    private UnitOfMeasurement $unitCode;

    public function __construct(float $quantity, UnitOfMeasurement $unitCode)
    {
        $this->quantity = new Quantity($quantity);
        $this->unitCode = $unitCode;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    public function getUnitCode(): UnitOfMeasurement
    {
        return $this->unitCode;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE, $this->quantity->getFormattedValueRounded());
        $element->setAttribute('unitCode', $this->unitCode->value);

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $billedQuantityElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $billedQuantityElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $billedQuantityElement */
        $billedQuantityElement = $billedQuantityElements->item(0);

        $billedQuantity = $billedQuantityElement->nodeValue;
        $unitCode       = '' !== $billedQuantityElement->getAttribute('unitCode') ?
            UnitOfMeasurement::tryFrom($billedQuantityElement->getAttribute('unitCode')) : null;

        if (null === $unitCode) {
            throw new \Exception('Wrong unitCode');
        }

        return new self((float) $billedQuantity, $unitCode);
    }
}
