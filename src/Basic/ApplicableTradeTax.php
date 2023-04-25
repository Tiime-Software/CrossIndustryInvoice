<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\SemanticDataType\Percentage;

class ApplicableTradeTax
{
    private string $typeCode;
    private VatCategory $categoryCode;
    private ?Percentage $rateApplicablePercent;
}
