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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): static
    {
        $exchangedDocumentContextElements = $xpath->query('//rsm:ExchangedDocumentContext', $currentElement);

        if (1 !== $exchangedDocumentContextElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $exchangedDocumentContextElement */
        $exchangedDocumentContextElement = $exchangedDocumentContextElements->item(0);

        $guidelineSpecifiedDocumentContextParameter       = GuidelineSpecifiedDocumentContextParameter::fromXML($xpath, $exchangedDocumentContextElement);
        $businessProcessSpecifiedDocumentContextParameter = BusinessProcessSpecifiedDocumentContextParameter::fromXML($xpath, $exchangedDocumentContextElement);

        $exchangedDocumentContext = new static($guidelineSpecifiedDocumentContextParameter);

        if (null !== $businessProcessSpecifiedDocumentContextParameter) {
            $exchangedDocumentContext->setBusinessProcessSpecifiedDocumentContextParameter($businessProcessSpecifiedDocumentContextParameter);
        }

        return $exchangedDocumentContext;
    }
}
