<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;

/**
 * BT-47-00.
 */
class BuyerSpecifiedLegalOrganization extends \Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization
{
    /**
     * BT-45.
     */
    private ?string $tradingBusinessName;

    public function __construct(LegalRegistrationIdentifier $identifier)
    {
        parent::__construct($identifier);
        $this->tradingBusinessName = null;
    }

    public function setTradingBusinessName(?string $tradingBusinessName): void
    {
        $this->tradingBusinessName = $tradingBusinessName;
    }

    public function getTradingBusinessName(): ?string
    {
        return $this->tradingBusinessName;
    }
}
