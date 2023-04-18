<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

/**
 * BT-30-00.
 */
class SellerSpecifiedLegalOrganization extends \Tiime\CrossIndustryInvoice\DataType\Minimum\SellerSpecifiedLegalOrganization
{
    /**
     * BT-28.
     */
    private ?string $tradingBusinessName;

    public function __construct()
    {
        parent::__construct();
        $this->tradingBusinessName = null;
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
