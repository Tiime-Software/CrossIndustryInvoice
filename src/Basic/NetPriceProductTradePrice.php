<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\Basic\BasisQuantity;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

class NetPriceProductTradePrice
{
    private UnitPriceAmount $unitPriceAmount;
    private ?BasisQuantity $basisQuantity;
}