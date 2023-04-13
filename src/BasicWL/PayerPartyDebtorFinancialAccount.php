<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\Identifier\DebitedAccountIdentifier;

/**
 * BT-91-00.
 */
class PayerPartyDebtorFinancialAccount
{
    /**
     * BT-91.
     */
    private DebitedAccountIdentifier $ibanId;
}
