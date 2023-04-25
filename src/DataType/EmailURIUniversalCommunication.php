<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-43-00 or BT-58-00.
 */
class EmailURIUniversalCommunication
{
    /**
     * BT-43 or BT-58.
     */
    private string $uriIdentifier;

    public function __construct(string $uriIdentifier)
    {
        $this->uriIdentifier = $uriIdentifier;
    }

    public function getUriIdentifier(): string
    {
        return $this->uriIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:EmailURIUniversalCommunication');

        $element->appendChild($document->createElement('ram:URIID', $this->uriIdentifier));

        return $element;
    }
}
