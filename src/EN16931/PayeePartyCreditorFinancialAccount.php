<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\Identifier\PaymentAccountIdentifier;

class PayeePartyCreditorFinancialAccount
{
    /**
     * BT-84.
     */
    private ?PaymentAccountIdentifier $ibanID;

    /**
     * BT-85.
     */
    private ?string $accountName;

    /**
     * BT-84-0.
     */
    private ?string $proprietaryID;

    public function __construct()
    {
        $this->ibanID        = null;
        $this->accountName   = null;
        $this->proprietaryID = null;
    }

    public function getIbanID(): ?PaymentAccountIdentifier
    {
        return $this->ibanID;
    }

    public function setIbanID(?PaymentAccountIdentifier $ibanID): void
    {
        $this->ibanID = $ibanID;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(?string $accountName): void
    {
        $this->accountName = $accountName;
    }

    public function getProprietaryID(): ?string
    {
        return $this->proprietaryID;
    }

    public function setProprietaryID(?string $proprietaryID): void
    {
        $this->proprietaryID = $proprietaryID;
    }
}
