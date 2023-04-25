<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\EN16931\DataType\Identifier\StandardItemIdentifier;

class SpecifiedTradeProduct
{
    private ?StandardItemIdentifier $globalIdentifier;
    private string $name;
}