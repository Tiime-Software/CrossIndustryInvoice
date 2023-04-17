<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\DebitedAccountIdentifier;

/**
 * BT-91-00.
 */
class PayerPartyDebtorFinancialAccount
{
    /**
     * BT-91.
     */
    private DebitedAccountIdentifier $ibanID;

    public function __construct(DebitedAccountIdentifier $ibanID)
    {
        $this->ibanID = $ibanID;
    }

    public function getIbanID(): DebitedAccountIdentifier
    {
        return $this->ibanID;
    }
}
