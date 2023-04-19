<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\EN16931\DataType\CountryAlpha2Code;

/**
 * BG-5.
 */
class PostalTradeAddress
{
    /**
     * BT-40.
     */
    private CountryAlpha2Code $countryID;

    public function __construct(CountryAlpha2Code $countryID)
    {
        $this->countryID = $countryID;
    }

    public function getCountryID(): CountryAlpha2Code
    {
        return $this->countryID;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement('ram:PostalTradeAddress');
        $currentNode->appendChild($document->createElement('ram:CountryID', $this->countryID->value));

        return $currentNode;
    }
}
