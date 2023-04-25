<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\MandateReferenceIdentifier;

/**
 * BT-20-00.
 */
class SpecifiedTradePaymentTerms
{
    /**
     * BT-20.
     */
    private ?string $description;

    /**
     * BT-9-00.
     */
    private ?DueDateDateTime $dueDateDateTime;

    /**
     * BT-89.
     */
    private ?MandateReferenceIdentifier $directDebitMandateIdentifier;

    public function __construct()
    {
        $this->dueDateDateTime              = null;
        $this->description                  = null;
        $this->directDebitMandateIdentifier = null;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDueDateDateTime(): DueDateDateTime
    {
        return $this->dueDateDateTime;
    }

    public function setDueDateDateTime(?DueDateDateTime $dueDateDateTime): static
    {
        $this->dueDateDateTime = $dueDateDateTime;

        return $this;
    }

    public function getDirectDebitMandateIdentifier(): ?MandateReferenceIdentifier
    {
        return $this->directDebitMandateIdentifier;
    }

    public function setDirectDebitMandateIdentifier(?MandateReferenceIdentifier $directDebitMandateIdentifier): static
    {
        $this->directDebitMandateIdentifier = $directDebitMandateIdentifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTradePaymentTerms');

        if (\is_string($this->description)) {
            $element->appendChild($document->createElement('ram:Description', $this->description));
        }

        if ($this->dueDateDateTime instanceof DueDateDateTime) {
            $element->appendChild($this->dueDateDateTime->toXML($document));
        }

        if ($this->directDebitMandateIdentifier instanceof MandateReferenceIdentifier) {
            $element->appendChild($document->createElement('ram:DirectDebitMandateID', $this->directDebitMandateIdentifier->value));
        }

        return $element;
    }
}
