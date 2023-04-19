<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\PayeeIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-60-0 & BT-60-1.
 */
class PayeeGlobalIdentifier extends PayeeIdentifier
{
    public function __construct(string $value, InternationalCodeDesignator $scheme)
    {
        parent::__construct($value, $scheme);
    }
}
