<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\Basic\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\Basic\LineSpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\Basic\LineSpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;

class SpecifiedLineTradeSettlement
{
    private ApplicableTradeTax $applicableTradeTax;
    private ?BillingSpecifiedPeriod $billingSpecifiedPeriod;

    /** @var array<int, LineSpecifiedTradeAllowance> */
    private array $specifiedTradeAllowance;

    /** @var array<int, LineSpecifiedTradeCharge> */
    private array $specifiedTradeCharge;

    private SpecifiedTradeSettlementLineMonetarySummation $specifiedTradeSettlementMonetarySummation;
}
