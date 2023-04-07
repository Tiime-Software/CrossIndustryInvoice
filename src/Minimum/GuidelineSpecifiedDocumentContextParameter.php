<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;

/**
 * BT-24-00
 */
class GuidelineSpecifiedDocumentContextParameter
{
    /**
     * BT-24
     */
    public SpecificationIdentifier $id;

    public function __construct(SpecificationIdentifier $id)
    {
        $this->id = $id;
    }

    public function getId(): SpecificationIdentifier
    {
        return $this->id;
    }
}