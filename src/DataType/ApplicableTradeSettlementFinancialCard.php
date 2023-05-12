<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BG-18.
 */
class ApplicableTradeSettlementFinancialCard
{
    protected const XML_NODE = 'ram:ApplicableTradeSettlementFinancialCard';

    /**
     * BT-87.
     */
    private string $identifier;

    /**
     * BT-88.
     */
    private ?string $cardholderName;

    public function __construct(string $identifier)
    {
        $this->identifier     = $identifier;
        $this->cardholderName = null;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getCardholderName(): ?string
    {
        return $this->cardholderName;
    }

    public function setCardholderName(?string $cardholderName): static
    {
        $this->cardholderName = $cardholderName;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:ID', $this->identifier));

        if (\is_string($this->cardholderName)) {
            $currentNode->appendChild($document->createElement('ram:CardholderName', $this->cardholderName));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $applicableTradeSettlementFinancialCardElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $applicableTradeSettlementFinancialCardElements->count()) {
            return null;
        }

        if ($applicableTradeSettlementFinancialCardElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $applicableTradeSettlementFinancialCardElement */
        $applicableTradeSettlementFinancialCardElement = $applicableTradeSettlementFinancialCardElements->item(0);

        $identifierElements     = $xpath->query('.//ram:ID', $applicableTradeSettlementFinancialCardElement);
        $cardholderNameElements = $xpath->query('.//ram:CardholderName', $applicableTradeSettlementFinancialCardElement);

        if (1 !== $identifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($cardholderNameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $identifier = $identifierElements->item(0)->nodeValue;

        $applicableTradeSettlementFinancialCard = new self($identifier);

        if (1 === $cardholderNameElements->count()) {
            $applicableTradeSettlementFinancialCard->setCardholderName($cardholderNameElements->item(0)->nodeValue);
        }

        return $applicableTradeSettlementFinancialCard;
    }
}
