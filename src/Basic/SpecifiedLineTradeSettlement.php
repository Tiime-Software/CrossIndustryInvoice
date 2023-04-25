<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\Basic\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;

class SpecifiedLineTradeSettlement
{
    private ApplicableTradeTax $applicableTradeTax;
    private ?BillingSpecifiedPeriod $billingSpecifiedPeriod;

    /** @var array<int, SpecifiedTradeAllowance> */
    private array $specifiedTradeAllowance;

    /** @var array<int, SpecifiedTradeCharge> */
    private array $specifiedTradeCharge;

    private SpecifiedTradeSettlementLineMonetarySummation $specifiedTradeSettlementMonetarySummation;
}
