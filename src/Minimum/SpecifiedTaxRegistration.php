<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-31-00.
 */
class SpecifiedTaxRegistration
{
    /**
     * BT-31.
     */
    private VatIdentifier $id;

    /**
     * BT-31-0.
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
