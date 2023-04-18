<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\VatIdentifier;

/**
 * BT-48-00.
 */
class SpecifiedTaxRegistration
{
    /**
     * BT-48.
     */
    private VatIdentifier $id;

    /**
     * BT-48-0.
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
