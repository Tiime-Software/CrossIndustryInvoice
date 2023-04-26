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

    public function setBusinessProcessSpecifiedDocumentContextParameter(?BusinessProcessSpecifiedDocumentContextParameter $businessProcessSpecifiedDocumentContextParameter): static
    {
        $this->businessProcessSpecifiedDocumentContextParameter = $businessProcessSpecifiedDocumentContextParameter;

        return $this;
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

    public static function fromXML(\DOMDocument $document): static
    {
        $xpath = new \DOMXPath($document);

        $businessProcessSpecifiedDocumentContextParameterElements = $xpath->query('//ram:BusinessProcessSpecifiedDocumentContextParameter');
        $guidelineSpecifiedDocumentContextParameterElements = $xpath->query('//ram:GuidelineSpecifiedDocumentContextParameter');

        if ($businessProcessSpecifiedDocumentContextParameterElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($guidelineSpecifiedDocumentContextParameterElements->count() !== 1) {
            throw new \Exception('Malformed');
        }

        $guidelineSpecifiedDocumentContextParameterDocument = new \DOMDocument();
        $guidelineSpecifiedDocumentContextParameterDocument->appendChild($guidelineSpecifiedDocumentContextParameterDocument->importNode($guidelineSpecifiedDocumentContextParameterElements->item(0), true));
        $guidelineSpecifiedDocumentContextParameter = GuidelineSpecifiedDocumentContextParameter::fromXML($guidelineSpecifiedDocumentContextParameterDocument);

        $exchangedDocumentContext = new static($guidelineSpecifiedDocumentContextParameter);

        if ($guidelineSpecifiedDocumentContextParameterElements->count() === 1) {
            $businessProcessSpecifiedDocumentContextParameterDocument = new \DOMDocument();
            $businessProcessSpecifiedDocumentContextParameterDocument->appendChild($businessProcessSpecifiedDocumentContextParameterDocument->importNode($guidelineSpecifiedDocumentContextParameterElements->item(0), true));
            $businessProcessSpecifiedDocumentContextParameter = BusinessProcessSpecifiedDocumentContextParameter::fromXML($businessProcessSpecifiedDocumentContextParameterDocument);

            $exchangedDocumentContext->setBusinessProcessSpecifiedDocumentContextParameter($businessProcessSpecifiedDocumentContextParameter);
        }

        return $exchangedDocumentContext;
    }
}
