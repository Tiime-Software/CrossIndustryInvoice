<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;

class GuidelineSpecifiedDocumentContextParameter
{
    public function __construct(public readonly SpecificationIdentifier $id)
    {
    }
}