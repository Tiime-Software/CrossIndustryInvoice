<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\SellerIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-29-0 & BT-29-1.
 */
class SellerGlobalIdentifier extends SellerIdentifier
{
    public function __construct(string $value, InternationalCodeDesignator $scheme)
    {
        parent::__construct($value, $scheme);
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        // todo
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        // todo
    }
}
