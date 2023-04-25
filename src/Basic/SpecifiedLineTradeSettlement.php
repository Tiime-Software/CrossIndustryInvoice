<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\EN16931\SpecifiedTradeSettlementLineMonetarySummation;

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