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
    private ?MandateReferenceIdentifier $directDebitMandateID;

    public function __construct()
    {
        $this->dueDateDateTime      = null;
        $this->description          = null;
        $this->directDebitMandateID = null;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDueDateDateTime(): DueDateDateTime
    {
        return $this->dueDateDateTime;
    }

    public function setDueDateDateTime(?DueDateDateTime $dueDateDateTime): void
    {
        $this->dueDateDateTime = $dueDateDateTime;
    }

    public function getDirectDebitMandateID(): ?MandateReferenceIdentifier
    {
        return $this->directDebitMandateID;
    }

    public function setDirectDebitMandateID(?MandateReferenceIdentifier $directDebitMandateID): void
    {
        $this->directDebitMandateID = $directDebitMandateID;
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

        if ($this->directDebitMandateID instanceof MandateReferenceIdentifier) {
            $element->appendChild($document->createElement('ram:DirectDebitMandateID', $this->directDebitMandateID->value));
        }

        return $element;
    }
}
