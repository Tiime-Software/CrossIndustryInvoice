<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;

/**
 * BG-2.
 */
class ExchangedDocumentContext
{
    /**
     * BT-23-00.
     */
    private ?BusinessProcessSpecifiedDocumentContextParameter $businessProcessSpecifiedDocumentContextParameter;

    /**
     * BT-24-00.
     */
    private GuidelineSpecifiedDocumentContextParameter $guidelineSpecifiedDocumentContextParameter;

    public function __construct()
    {
        $this->guidelineSpecifiedDocumentContextParameter = new GuidelineSpecifiedDocumentContextParameter(
            new SpecificationIdentifier(SpecificationIdentifier::MINIMUM)
        );
        $this->businessProcessSpecifiedDocumentContextParameter = null;
    }

    public function getBusinessProcessSpecifiedDocumentContextParameter(): ?BusinessProcessSpecifiedDocumentContextParameter
    {
        return $this->businessProcessSpecifiedDocumentContextParameter;
    }

    public function setBusinessProcessSpecifiedDocumentContextParameter(?BusinessProcessSpecifiedDocumentContextParameter $businessProcessSpecifiedDocumentContextParameter): void
    {
        $this->businessProcessSpecifiedDocumentContextParameter = $businessProcessSpecifiedDocumentContextParameter;
    }

    public function getGuidelineSpecifiedDocumentContextParameter(): GuidelineSpecifiedDocumentContextParameter
    {
        return $this->guidelineSpecifiedDocumentContextParameter;
    }
}
