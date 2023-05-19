<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement;

/**
 * BT-133-00.
 */
class ReceivableSpecifiedTradeAccountingAccount
{
    protected const XML_NODE = 'ram:ReceivableSpecifiedTradeAccountingAccount';

    /**
     * BT-133.
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
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:ID', $this->identifier));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $receivableSpecifiedTradeAccountingAccountElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $receivableSpecifiedTradeAccountingAccountElements->count()) {
            return null;
        }

        if ($receivableSpecifiedTradeAccountingAccountElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $receivableSpecifiedTradeAccountingAccountElement */
        $receivableSpecifiedTradeAccountingAccountElement = $receivableSpecifiedTradeAccountingAccountElements->item(0);

        $identifierElements = $xpath->query('.//ram:ID', $receivableSpecifiedTradeAccountingAccountElement);

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $identifier = $identifierElements->item(0)->nodeValue;

        return new self($identifier);
    }
}
