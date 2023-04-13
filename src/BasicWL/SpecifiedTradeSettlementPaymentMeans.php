<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\PaymentMeansCode;

/**
 * BG-16.
 */
class SpecifiedTradeSettlementPaymentMeans
{
    /**
     * BT-81.
     */
    private PaymentMeansCode $typeCode;

    /**
     * BT-91-00.
     */
    private ?PayerPartyDebtorFinancialAccount $payerPartyDebtorFinancialAccount;

    /**
     * BG-17.
     *
     * @var array<int, PayeePartyCreditorFinancialAccount>
     */
    private array $payeePartyCreditorFinancialAccounts;
}
