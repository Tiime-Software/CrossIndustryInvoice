<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\EN16931\DataType\Identifier\LocationIdentifier;

/**
 * BG-13.
 */
class ShipToTradeParty
{
    /**
     * BT-71.
     */
    private ?LocationIdentifier $identifier;

    /**
     * BT-71-0 & BT-71-1.
     */
    private ?LocationGlobalIdentifier $globalId;

    /**
     * BT-70.
     */
    private ?string $name;

    /**
     * BG-15.
     */
    private ?PostalTradeAddress $postalTradeAddress;

    public function __construct()
    {
        $this->identifier         = null;
        $this->globalId           = null;
        $this->name               = null;
        $this->postalTradeAddress = null;
    }

    public function getIdentifier(): ?LocationIdentifier
    {
        return $this->identifier;
    }

    public function setIdentifier(?LocationIdentifier $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getGlobalId(): ?LocationGlobalIdentifier
    {
        return $this->globalId;
    }

    public function setGlobalId(?LocationGlobalIdentifier $globalId): void
    {
        $this->globalId = $globalId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getPostalTradeAddress(): ?PostalTradeAddress
    {
        return $this->postalTradeAddress;
    }

    public function setPostalTradeAddress(?PostalTradeAddress $postalTradeAddress): void
    {
        $this->postalTradeAddress = $postalTradeAddress;
    }
}
