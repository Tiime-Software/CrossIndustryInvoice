<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\BuyerIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-46-0 & BT-46-1.
 */
class BuyerGlobalIdentifier extends BuyerIdentifier
{
    protected const XML_NODE = 'ram:GlobalID';

    public function __construct(string $value, InternationalCodeDesignator $scheme)
    {
        parent::__construct($value, $scheme);
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:GlobalID', $this->value);
        $currentNode->setAttribute('schemeID', $this->scheme->value);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $buyerGlobalIdentifierElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $buyerGlobalIdentifierElements->count()) {
            return null;
        }

        if ($buyerGlobalIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $buyerGlobalIdentifierElement */
        $buyerGlobalIdentifierElement = $buyerGlobalIdentifierElements->item(0);

        $identifier = $buyerGlobalIdentifierElement->nodeValue;
        $scheme     = '' !== $buyerGlobalIdentifierElement->getAttribute('schemeID') ?
            InternationalCodeDesignator::tryFrom($buyerGlobalIdentifierElement->getAttribute('schemeID')) : null;

        if (null === $scheme) {
            throw new \Exception('Wrong schemeID');
        }

        return new static($identifier, $scheme);
    }
}
