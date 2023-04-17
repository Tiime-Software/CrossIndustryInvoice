<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\SellerTradeParty;

/**
 * BT-29.
 */
class SellerIdentifier
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
