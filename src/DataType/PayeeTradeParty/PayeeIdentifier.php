<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty;

/**
 * BT-60.
 */
class PayeeIdentifier
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
