<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\EN16931\NetPriceProductTradePrice\BasisQuantity;
use Tiime\EN16931\SemanticDataType\UnitPriceAmount;

class NetPriceProductTradePrice
{
    private UnitPriceAmount $unitPriceAmount;
    private ?BasisQuantity $basisQuantity;
}