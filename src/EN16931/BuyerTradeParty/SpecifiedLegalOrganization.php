<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty;

use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-47-00.
 */
class SpecifiedLegalOrganization
{
    /**
     * BT-47.
     */
    private string $id;

    /**
     * BT-47-1.
     */
    private ?InternationalCodeDesignator $schemeID;

    /**
     * BT-45.
     */
    private ?string $tradingBusinessName;

    public function __construct(string $id)
    {
        $this->id                  = $id;
        $this->schemeID            = null;
        $this->tradingBusinessName = null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSchemeID(): ?InternationalCodeDesignator
    {
        return $this->schemeID;
    }

    public function setSchemeID(?InternationalCodeDesignator $schemeID): void
    {
        $this->schemeID = $schemeID;
    }

    public function getTradingBusinessName(): ?string
    {
        return $this->tradingBusinessName;
    }

    public function setTradingBusinessName(?string $tradingBusinessName): void
    {
        $this->tradingBusinessName = $tradingBusinessName;
    }
}
