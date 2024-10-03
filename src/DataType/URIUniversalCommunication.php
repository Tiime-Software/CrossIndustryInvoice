<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\ElectronicAddressScheme;
use Tiime\EN16931\DataType\Identifier\ElectronicAddressIdentifier;

/**
 * BT-34-00 or BT-49-00.
 */
class URIUniversalCommunication
{
    protected const XML_NODE = 'ram:URIUniversalCommunication';

    /**
     * @param ElectronicAddressIdentifier $electronicAddress - BT-34 or BT-49
     */
    public function __construct(
        private ElectronicAddressIdentifier $electronicAddress,
    ) {
    }

    public function getElectronicAddress(): ElectronicAddressIdentifier
    {
        return $this->electronicAddress;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $uriIdElement = $document->createElement('ram:URIID', $this->electronicAddress->value);
        $uriIdElement->setAttribute('schemeID', $this->electronicAddress->scheme->value);
        $currentNode->appendChild($uriIdElement);

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $uriUniversalCommunicationElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $uriUniversalCommunicationElements->count()) {
            return null;
        }

        if ($uriUniversalCommunicationElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $uriUniversalCommunicationElement */
        $uriUniversalCommunicationElement = $uriUniversalCommunicationElements->item(0);

        $electronicAddressElements = $xpath->query('./ram:URIID', $uriUniversalCommunicationElement);

        if (1 !== $electronicAddressElements->count()) {
            throw new \Exception('Malformed');
        }

        $electronicAddressItem = $electronicAddressElements->item(0);
        $electronicAddress     = $electronicAddressItem->nodeValue;
        $scheme                = '' !== $electronicAddressItem->getAttribute('schemeID') ?
            ElectronicAddressScheme::tryFrom($electronicAddressItem->getAttribute('schemeID')) : null;

        if (null === $scheme) {
            throw new \Exception('Wrong schemeID');
        }

        return new self(new ElectronicAddressIdentifier($electronicAddress, $scheme));
    }
}
