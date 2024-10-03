<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\Invoice;

/**
 * BG-2.
 */
class ExchangedDocumentContext
{
    protected const XML_NODE = 'rsm:ExchangedDocumentContext';

    /**
     * BT-23-00.
     */
    private ?BusinessProcessSpecifiedDocumentContextParameter $businessProcessSpecifiedDocumentContextParameter;

    /**
     * @param GuidelineSpecifiedDocumentContextParameter $guidelineSpecifiedDocumentContextParameter - BT-24-00
     */
    public function __construct(
        private GuidelineSpecifiedDocumentContextParameter $guidelineSpecifiedDocumentContextParameter,
    ) {
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
        $element = $document->createElement(self::XML_NODE);

        if ($this->businessProcessSpecifiedDocumentContextParameter instanceof BusinessProcessSpecifiedDocumentContextParameter) {
            $element->appendChild($this->businessProcessSpecifiedDocumentContextParameter->toXML($document));
        }

        $element->appendChild($this->guidelineSpecifiedDocumentContextParameter->toXML($document));

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $exchangedDocumentContextElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $exchangedDocumentContextElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $exchangedDocumentContextElement */
        $exchangedDocumentContextElement = $exchangedDocumentContextElements->item(0);

        $guidelineSpecifiedDocumentContextParameter       = GuidelineSpecifiedDocumentContextParameter::fromXML($xpath, $exchangedDocumentContextElement);
        $businessProcessSpecifiedDocumentContextParameter = BusinessProcessSpecifiedDocumentContextParameter::fromXML($xpath, $exchangedDocumentContextElement);

        $exchangedDocumentContext = new self($guidelineSpecifiedDocumentContextParameter);

        if ($businessProcessSpecifiedDocumentContextParameter instanceof BusinessProcessSpecifiedDocumentContextParameter) {
            $exchangedDocumentContext->setBusinessProcessSpecifiedDocumentContextParameter($businessProcessSpecifiedDocumentContextParameter);
        }

        return $exchangedDocumentContext;
    }

    public static function fromEN16931(Invoice $invoice): self
    {
        $processControl = $invoice->getProcessControl();

        $guidelineSpecifiedDocumentContextParameter = new GuidelineSpecifiedDocumentContextParameter($invoice->getProcessControl()->getSpecificationIdentifier());

        $exchangedDocumentContext = new self($guidelineSpecifiedDocumentContextParameter);

        if (\is_string($processControl->getBusinessProcessType())) {
            $exchangedDocumentContext->setBusinessProcessSpecifiedDocumentContextParameter(
                new BusinessProcessSpecifiedDocumentContextParameter($processControl->getBusinessProcessType())
            );
        }

        return $exchangedDocumentContext;
    }
}
