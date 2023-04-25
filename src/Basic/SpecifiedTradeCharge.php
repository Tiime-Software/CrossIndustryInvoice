<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\ChargeChargeIndicator;
use Tiime\EN16931\DataType\ChargeReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;

class SpecifiedTradeCharge
{
    private ChargeChargeIndicator $chargeIndicator;
    private Amount $actualAmount;
    private ?ChargeReasonCode $reasonCode;
    private ?string $reason;
}