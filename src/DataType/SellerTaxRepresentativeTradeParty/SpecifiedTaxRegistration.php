<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\SellerTaxRepresentativeTradeParty;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-63-00.
 */
class SpecifiedTaxRegistration
{
    /**
     * BT-63.
     */
    private VatIdentifier $id;

    /**
     * BT-63-0.
     */
    private string $schemeID;

    public function __construct(VatIdentifier $id)
    {
        $this->id       = $id;
        $this->schemeID = 'VA';
    }

    public function getId(): VatIdentifier
    {
        return $this->id;
    }

    public function getSchemeID(): string
    {
        return $this->schemeID;
    }
}
