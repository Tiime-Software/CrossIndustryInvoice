<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\EN16931\DataType\UnitOfMeasurement;
use Tiime\EN16931\SemanticDataType\Quantity;

/**
 * BT-149-1 & BT-150-1.
 */
class BasisQuantity
{
    /**
     * BT-149-1.
     */
    private Quantity $value;

    /**
     * BT-150-1.
     */
    private ?UnitOfMeasurement $unitCode;

    public function __construct(float $value)
    {
        $this->value    = new Quantity($value);
        $this->unitCode = null;
    }

    public function getValue(): float
    {
        return $this->value->getValue();
    }

    public function getUnitCode(): ?UnitOfMeasurement
    {
        return $this->unitCode;
    }

    public function setUnitCode(?UnitOfMeasurement $unitCode): static
    {
        $this->unitCode = $unitCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:BasisQuantity', (string) $this->value->getValueRounded());

        if ($this->unitCode instanceof UnitOfMeasurement) {
            $element->setAttribute('unitCode', $this->unitCode->value);
        }

        return $element;
    }
}
