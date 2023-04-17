<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\Identifier\ElectronicAddressIdentifier;

/**
 * BT-34-00 or BT-49-00.
 */
class URIUniversalCommunication
{
    /**
     * BT-34 or BT-49.
     */
    private ElectronicAddressIdentifier $electronicAddress;

    public function __construct(ElectronicAddressIdentifier $electronicAddress)
    {
        $this->electronicAddress = $electronicAddress;
    }

    public function getElectronicAddress(): ElectronicAddressIdentifier
    {
        return $this->electronicAddress;
    }
}
