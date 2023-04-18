<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\DataType\EN16931\PayeeSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty\PayeeIdentifier;
use Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty\PayeeIdentifierGlobalId;

/**
 * BG-10.
 */
class PayeeTradeParty
{
    /**
     * BT-60.
     */
    private ?PayeeIdentifier $id;

    /**
     * BT-60-0 & BT-60-1.
     */
    private ?PayeeIdentifierGlobalId $globalId;

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
        $this->id                         = null;
        $this->globalId                   = null;
        $this->specifiedLegalOrganization = null;
    }

    public function getId(): ?PayeeIdentifier
    {
        return $this->id;
    }

    public function setId(?PayeeIdentifier $id): void
    {
        $this->id = $id;
    }

    public function getGlobalId(): ?PayeeIdentifierGlobalId
    {
        return $this->globalId;
    }

    public function setGlobalId(?PayeeIdentifierGlobalId $globalId): void
    {
        $this->globalId = $globalId;
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
