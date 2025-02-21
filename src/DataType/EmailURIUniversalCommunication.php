<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\Utils\XPath;

/**
 * BT-43-00 or BT-58-00.
 */
class EmailURIUniversalCommunication
{
    protected const string XML_NODE = 'ram:EmailURIUniversalCommunication';

    /**
     * @param string $uriIdentifier - BT-43 or BT-58
     */
    public function __construct(
        private readonly string $uriIdentifier,
    ) {
    }

    public function getUriIdentifier(): string
    {
        return $this->uriIdentifier;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:URIID', $this->uriIdentifier));

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): ?self
    {
        $emailURIUniversalCommunicationElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $emailURIUniversalCommunicationElements->count()) {
            return null;
        }

        if ($emailURIUniversalCommunicationElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $emailURIUniversalCommunicationElement */
        $emailURIUniversalCommunicationElement = $emailURIUniversalCommunicationElements->item(0);

        $uriIdentifierElements = $xpath->query('./ram:URIID', $emailURIUniversalCommunicationElement);

        if (1 !== $uriIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        $uriIdentifier = $uriIdentifierElements->item(0)->nodeValue;

        return new self($uriIdentifier);
    }
}
