<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\GrossPriceProductTradePrice;

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

    public function setUnitCode(?UnitOfMeasurement $unitCode): void
    {
        $this->unitCode = $unitCode;
    }
}