<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\UnitOfMeasurement;
use Tiime\EN16931\SemanticDataType\Quantity;

/**
 * BT-129 & BT-130.
 */
class BilledQuantity
{
    /**
     * BT-129.
     */
    private Quantity $value;

    /**
     * BT-130.
     */
    private UnitOfMeasurement $unitCode;

    public function __construct(float $value, UnitOfMeasurement $unitCode)
    {
        $this->value    = new Quantity($value);
        $this->unitCode = $unitCode;
    }

    public function getValue(): Quantity
    {
        return $this->value;
    }

    public function getUnitCode(): UnitOfMeasurement
    {
        return $this->unitCode;
    }
}