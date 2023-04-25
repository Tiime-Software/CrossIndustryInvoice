<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\Basic\AppliedTradeAllowanceCharge;
use Tiime\CrossIndustryInvoice\DataType\Basic\BasisQuantity;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

class GrossPriceProductTradePrice
{
    private UnitPriceAmount $chargeAmount;
    private ?BasisQuantity $basisQuantity;
    private ?AppliedTradeAllowanceCharge $appliedTradeAllowanceCharge;
}