<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\AllowanceChargeIndicator;
use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\SemanticDataType\Amount;

class SpecifiedTradeAllowance
{
    private AllowanceChargeIndicator $chargeIndicator;
    private Amount $actualAmount;
    private ?AllowanceReasonCode $reasonCode;
    private ?string $reason;
}