<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement;

/**
 * BT-133-00.
 */
class ReceivableSpecifiedTradeAccountingAccount
{
    /**
     * BT-133.
     */
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:ReceivableSpecifiedTradeAccountingAccount');

        $element->appendChild($document->createElement('ram:ID', $this->id));

        return $element;
    }
}
