<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-31-00.
 */
class SpecifiedTaxRegistrationVAT
{
    /**
     * BT-31.
     */
    private ?VatIdentifier $id;

    /**
     * BT-31-0.
     */
    private string $schemeID;

    public function __construct()
    {
        $this->schemeID = 'VA';
        $this->id       = null;
    }

    public function getId(): ?VatIdentifier
    {
        return $this->id;
    }

    public function setId(?VatIdentifier $id): void
    {
        $this->id = $id;
    }

    public function getSchemeID(): string
    {
        return $this->schemeID;
    }
}
