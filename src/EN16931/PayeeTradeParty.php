<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\PayeeTradeParty\PayeeIdentifier;
use Tiime\CrossIndustryInvoice\EN16931\PayeeTradeParty\PayeeIdentifierGlobalId;
use Tiime\CrossIndustryInvoice\EN16931\PayeeTradeParty\SpecifiedLegalOrganization;

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
    private ?SpecifiedLegalOrganization $specifiedLegalOrganization;

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

    public function getSpecifiedLegalOrganization(): ?SpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?SpecifiedLegalOrganization $specifiedLegalOrganization): void
    {
        $this->specifiedLegalOrganization = $specifiedLegalOrganization;
    }
}
