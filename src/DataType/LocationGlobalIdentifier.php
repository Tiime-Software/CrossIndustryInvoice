<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\LocationIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-71-0 & BT-71-1.
 */
class LocationGlobalIdentifier extends LocationIdentifier
{
    public function __construct(string $value, InternationalCodeDesignator $scheme)
    {
        parent::__construct($value, $scheme);
    }
}
