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
}
