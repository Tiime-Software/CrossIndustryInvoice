<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\EN16931\DataType\Identifier\PaymentAccountIdentifier;

class PayeePartyCreditorFinancialAccount extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeePartyCreditorFinancialAccount
{
    /**
     * BT-85.
     */
    private ?string $accountName;

    public function __construct(
        ?PaymentAccountIdentifier $ibanId = null,
        ?string $accountName = null,
        ?PaymentAccountIdentifier $proprietaryId = null
    ) {
        parent::__construct($ibanId, $proprietaryId);

        $this->accountName = $accountName;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(?string $accountName): void
    {
        $this->accountName = $accountName;
    }
}