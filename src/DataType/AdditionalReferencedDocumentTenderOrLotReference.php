<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\BinaryObject;
use Tiime\EN16931\DataType\MimeCode;
use Tiime\EN16931\DataType\Reference\TenderOrLotReference;

/**
 * BT-17-00.
 */
class AdditionalReferencedDocumentTenderOrLotReference
{
    protected const XML_NODE = 'ram:AdditionalReferencedDocument';

    /**
     * BT-124.
     */
    private ?string $uriIdentifier;

    /**
     * BT-17-0.
     */
    private string $typeCode;

    /**
     * BT-123.
     */
    private ?string $name;

    /**
     * BT-125.
     */
    private ?BinaryObject $attachmentBinaryObject;

    /**
     * @param TenderOrLotReference $issuerAssignedIdentifier - BT-17
     */
    public function __construct(
        private TenderOrLotReference $issuerAssignedIdentifier,
    ) {
        $this->typeCode               = '50';
        $this->uriIdentifier          = null;
        $this->name                   = null;
        $this->attachmentBinaryObject = null;
    }

    public function getIssuerAssignedIdentifier(): TenderOrLotReference
    {
        return $this->issuerAssignedIdentifier;
    }

    public function getUriIdentifier(): ?string
    {
        return $this->uriIdentifier;
    }

    public function setUriIdentifier(?string $uriIdentifier): static
    {
        $this->uriIdentifier = $uriIdentifier;

        return $this;
    }

    public function getTypeCode(): string
    {
        return $this->typeCode;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAttachmentBinaryObject(): ?BinaryObject
    {
        return $this->attachmentBinaryObject;
    }

    public function setAttachmentBinaryObject(?BinaryObject $attachmentBinaryObject): static
    {
        $this->attachmentBinaryObject = $attachmentBinaryObject;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        if (\is_string($this->uriIdentifier)) {
            $currentNode->appendChild($document->createElement('ram:URIID', $this->uriIdentifier));
        }

        $currentNode->appendChild($document->createElement('ram:TypeCode', $this->typeCode));

        if (\is_string($this->name)) {
            $currentNode->appendChild($document->createElement('ram:Name', $this->name));
        }

        if ($this->attachmentBinaryObject instanceof BinaryObject) {
            $binaryObjectElement = $document->createElement('ram:AttachmentBinaryObject', $this->attachmentBinaryObject->content);
            $binaryObjectElement->setAttribute('mimeCode', $this->attachmentBinaryObject->mimeCode->value);
            $binaryObjectElement->setAttribute('filename', $this->attachmentBinaryObject->filename);

            $currentNode->appendChild($binaryObjectElement);
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $additionalReferencedDocumentTenderOrLotReferenceElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $additionalReferencedDocumentTenderOrLotReferenceElements->count()) {
            return null;
        }

        if ($additionalReferencedDocumentTenderOrLotReferenceElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $additionalReferencedDocumentTenderOrLotReferenceElement */
        $additionalReferencedDocumentTenderOrLotReferenceElement = $additionalReferencedDocumentTenderOrLotReferenceElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('./ram:IssuerAssignedID', $additionalReferencedDocumentTenderOrLotReferenceElement);
        $uriIdentifierElements            = $xpath->query('./ram:URIID', $additionalReferencedDocumentTenderOrLotReferenceElement);
        $typeCodeElements                 = $xpath->query('./ram:TypeCode', $additionalReferencedDocumentTenderOrLotReferenceElement);
        $nameElements                     = $xpath->query('./ram:Name', $additionalReferencedDocumentTenderOrLotReferenceElement);
        $attachmentBinaryObjectElements   = $xpath->query('./ram:AttachmentBinaryObject', $additionalReferencedDocumentTenderOrLotReferenceElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($uriIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $typeCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($nameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($attachmentBinaryObjectElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $issuerAssignedIdentifier = $issuerAssignedIdentifierElements->item(0)->nodeValue;
        $typeCode                 = $typeCodeElements->item(0)->nodeValue;

        if ('50' !== $typeCode) {
            throw new \Exception('Wrong TypeCode');
        }

        $additionalReferencedDocumentTenderOrLotReference = new self(new TenderOrLotReference($issuerAssignedIdentifier));

        if (1 === $uriIdentifierElements->count()) {
            $additionalReferencedDocumentTenderOrLotReference->setUriIdentifier($uriIdentifierElements->item(0)->nodeValue);
        }

        if (1 === $nameElements->count()) {
            $additionalReferencedDocumentTenderOrLotReference->setName($nameElements->item(0)->nodeValue);
        }

        if (1 === $attachmentBinaryObjectElements->count()) {
            $attachmentBinaryObjectItem = $attachmentBinaryObjectElements->item(0);
            $content                    = $attachmentBinaryObjectItem->nodeValue;
            $mimeCode                   = MimeCode::tryFrom($attachmentBinaryObjectItem->getAttribute('mimeCode'));

            if (!$mimeCode instanceof MimeCode) {
                throw new \Exception('Wrong mimeCode');
            }

            $filename = $attachmentBinaryObjectItem->getAttribute('filename');

            $additionalReferencedDocumentTenderOrLotReference->setAttachmentBinaryObject(new BinaryObject($content, $mimeCode, $filename));
        }

        return $additionalReferencedDocumentTenderOrLotReference;
    }
}
