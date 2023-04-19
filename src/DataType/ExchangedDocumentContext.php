<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

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

    public function __construct(GuidelineSpecifiedDocumentContextParameter $guidelineSpecifiedDocumentContextParameter)
    {
        $this->guidelineSpecifiedDocumentContextParameter       = $guidelineSpecifiedDocumentContextParameter;
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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('rsm:ExchangedDocumentContext');

        if ($this->businessProcessSpecifiedDocumentContextParameter instanceof BusinessProcessSpecifiedDocumentContextParameter) {
            $element->appendChild($this->businessProcessSpecifiedDocumentContextParameter->toXML($document));
        }

        $element->appendChild($this->guidelineSpecifiedDocumentContextParameter->toXML($document));

        return $element;
    }
}
