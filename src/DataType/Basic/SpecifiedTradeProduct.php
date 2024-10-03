<?php

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\EN16931\DataType\Identifier\StandardItemIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BG-31.
 */
class SpecifiedTradeProduct
{
    protected const XML_NODE = 'ram:SpecifiedTradeProduct';

    /**
     * BT-157.
     */
    protected ?StandardItemIdentifier $globalIdentifier;

    /**
     * @param string $name - BT-153
     */
    public function __construct(
        protected string $name,
    ) {
        $this->globalIdentifier = null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGlobalIdentifier(): ?StandardItemIdentifier
    {
        return $this->globalIdentifier;
    }

    public function setGlobalIdentifier(?StandardItemIdentifier $globalIdentifier): self
    {
        $this->globalIdentifier = $globalIdentifier;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->globalIdentifier instanceof StandardItemIdentifier) {
            $identifierElement = $document->createElement('ram:GlobalID', $this->globalIdentifier->value);
            $identifierElement->setAttribute('schemeID', $this->globalIdentifier->scheme->value);
            $currentNode->appendChild($identifierElement);
        }

        $currentNode->appendChild($document->createElement('ram:Name', $this->name));

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $specifiedTradeProductElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $specifiedTradeProductElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedTradeProductElement */
        $specifiedTradeProductElement = $specifiedTradeProductElements->item(0);

        $globalIdentifierElements = $xpath->query('./ram:GlobalID', $specifiedTradeProductElement);
        $nameElements             = $xpath->query('./ram:Name', $specifiedTradeProductElement);

        if ($globalIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $specifiedTradeProduct = new self($name);

        if (1 === $globalIdentifierElements->count()) {
            $globalIdentifierElement = $globalIdentifierElements->item(0);

            $scheme = $globalIdentifierElement->hasAttribute('schemeID') ?
                InternationalCodeDesignator::tryFrom($globalIdentifierElement->getAttribute('schemeID')) : null;

            if (null === $scheme) {
                throw new \Exception('Wrong schemeID');
            }

            $specifiedTradeProduct->setGlobalIdentifier(
                new StandardItemIdentifier(
                    value: $globalIdentifierElement->nodeValue,
                    scheme: $scheme
                )
            );
        }

        return $specifiedTradeProduct;
    }
}
