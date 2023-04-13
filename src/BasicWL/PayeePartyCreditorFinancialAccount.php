<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\Identifier\PaymentAccountIdentifier;

/**
 * BG-17.
 */
class PayeePartyCreditorFinancialAccount
{
    /**
     * BT-84.
     */
    private ?PaymentAccountIdentifier $ibanId;

    /**
     * BT-84-0.
     */
    private ?PaymentAccountIdentifier $proprietaryId;
}
