<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;

/**
 * BT-30-00.
 */
class SpecifiedLegalOrganization
{
    /**
     * BT-30 & BT-30-1.
     */
    private ?LegalRegistrationIdentifier $legalRegistrationIdentifier;

    /**
     * BT-28.
     */
    private ?string $tradingBusinessName;

    public function __construct()
    {
        $this->legalRegistrationIdentifier = null;
        $this->tradingBusinessName         = null;
    }

    public function getLegalRegistrationIdentifier(): ?LegalRegistrationIdentifier
    {
        return $this->legalRegistrationIdentifier;
    }

    public function setLegalRegistrationIdentifier(?LegalRegistrationIdentifier $legalRegistrationIdentifier): void
    {
        $this->legalRegistrationIdentifier = $legalRegistrationIdentifier;
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
