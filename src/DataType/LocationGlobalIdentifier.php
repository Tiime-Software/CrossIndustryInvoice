<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\Codelist\InternationalCodeDesignator;
use Tiime\EN16931\DataType\Identifier\LocationIdentifier;

/**
 * BT-71-0 & BT-71-1.
 */
readonly class LocationGlobalIdentifier extends LocationIdentifier
{
    protected const string XML_NODE = 'ram:GlobalID';

    public function __construct(string $value, InternationalCodeDesignator $scheme)
    {
        parent::__construct($value, $scheme);
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $locationGlobalIdentifierElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $locationGlobalIdentifierElements->count()) {
            return null;
        }

        if ($locationGlobalIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $locationGlobalIdentifierElement */
        $locationGlobalIdentifierElement = $locationGlobalIdentifierElements->item(0);

        $identifier = $locationGlobalIdentifierElement->nodeValue;
        $scheme     = '' !== $locationGlobalIdentifierElement->getAttribute('schemeID') ?
            InternationalCodeDesignator::tryFrom($locationGlobalIdentifierElement->getAttribute('schemeID')) : null;

        if (null === $scheme) {
            throw new \Exception('Wrong schemeID');
        }

        return new self($identifier, $scheme);
    }
}
