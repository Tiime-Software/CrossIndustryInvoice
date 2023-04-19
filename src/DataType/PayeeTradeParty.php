<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeeSpecifiedLegalOrganization;
use Tiime\EN16931\DataType\Identifier\PayeeIdentifier;

/**
 * BG-10.
 */
class PayeeTradeParty
{
    /**
     * BT-60.
     */
    private ?PayeeIdentifier $identifier;

    /**
     * BT-60-0 & BT-60-1.
     */
    private ?PayeeGlobalIdentifier $globalIdentifier;

    /**
     * BT-59.
     */
    private string $name;

    /**
     * BT-61-00.
     */
    private ?PayeeSpecifiedLegalOrganization $specifiedLegalOrganization;

    public function __construct(string $name)
    {
        $this->name                       = $name;
        $this->identifier                 = null;
        $this->globalIdentifier           = null;
        $this->specifiedLegalOrganization = null;
    }

    public function getIdentifier(): ?PayeeIdentifier
    {
        return $this->identifier;
    }

    public function setIdentifier(?PayeeIdentifier $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getGlobalIdentifier(): ?PayeeGlobalIdentifier
    {
        return $this->globalIdentifier;
    }

    public function setGlobalIdentifier(?PayeeGlobalIdentifier $globalIdentifier): void
    {
        $this->globalIdentifier = $globalIdentifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpecifiedLegalOrganization(): ?PayeeSpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?PayeeSpecifiedLegalOrganization $specifiedLegalOrganization): void
    {
        $this->specifiedLegalOrganization = $specifiedLegalOrganization;
    }
}
