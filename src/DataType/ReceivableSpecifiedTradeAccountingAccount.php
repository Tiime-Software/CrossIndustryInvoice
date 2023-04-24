<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-19-00.
 */
class ReceivableSpecifiedTradeAccountingAccount
{
    /**
     * BT-19.
     */
    private string $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ReceivableSpecifiedTradeAccountingAccount');

        $element->appendChild($document->createElement('ram:ID', $this->identifier));

        return $element;
    }
}
