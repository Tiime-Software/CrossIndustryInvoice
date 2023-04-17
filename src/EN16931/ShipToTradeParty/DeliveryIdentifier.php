<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ShipToTradeParty;

/**
 * BT-71.
 */
class DeliveryIdentifier
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
