<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\ShipToTradeParty\DeliveryIdentifier;
use Tiime\CrossIndustryInvoice\EN16931\ShipToTradeParty\DeliveryIdentifierGlobalId;
use Tiime\CrossIndustryInvoice\EN16931\ShipToTradeParty\PostalTradeAddress;

/**
 * BG-13.
 */
class ShipToTradeParty
{
    /**
     * BT-71.
     */
    private ?DeliveryIdentifier $id;

    /**
     * BT-71-0 & BT-71-1.
     */
    private ?DeliveryIdentifierGlobalId $globalId;

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
        $this->id                 = null;
        $this->globalId           = null;
        $this->name               = null;
        $this->postalTradeAddress = null;
    }

    public function getId(): ?DeliveryIdentifier
    {
        return $this->id;
    }

    public function setId(?DeliveryIdentifier $id): void
    {
        $this->id = $id;
    }

    public function getGlobalId(): ?DeliveryIdentifierGlobalId
    {
        return $this->globalId;
    }

    public function setGlobalId(?DeliveryIdentifierGlobalId $globalId): void
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
