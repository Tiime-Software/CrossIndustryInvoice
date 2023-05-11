<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeAgreement;

use Tiime\EN16931\DataType\BinaryObject;
use Tiime\EN16931\DataType\Identifier\ObjectIdentifier;
use Tiime\EN16931\DataType\MimeCode;

/**
 * BT-18-00.
 */
class AdditionalReferencedDocumentInvoicedObjectIdentifier
{
    protected const XML_NODE = 'ram:AdditionalReferencedDocument';

    /**
     * BT-18.
     */
    private ObjectIdentifier $issuerAssignedIdentifier;

    /**
     * BT-124.
     */
    private ?string $uriIdentifier;

    /**
     * BT-18-0.
     */
    private string $typeCode;

    /**
     * BT-18-1.
     */
    private ?string $referenceTypeCode;

    /**
     * BT-123.
     */
    private ?string $name;

    /**
     * BT-125.
     */
    private ?BinaryObject $attachmentBinaryObject;

    public function __construct(ObjectIdentifier $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
        $this->typeCode                 = '130';
        $this->referenceTypeCode        = null;
        $this->uriIdentifier            = null;
        $this->name                     = null;
        $this->attachmentBinaryObject   = null;
    }

    public function getIssuerAssignedIdentifier(): ObjectIdentifier
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

    public function getReferenceTypeCode(): ?string
    {
        return $this->referenceTypeCode;
    }

    public function setReferenceTypeCode(?string $referenceTypeCode): static
    {
        $this->referenceTypeCode = $referenceTypeCode;

        return $this;
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
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:IssuerAssignedID', $this->issuerAssignedIdentifier->value));

        if (\is_string($this->uriIdentifier)) {
            $element->appendChild($document->createElement('ram:URIID', $this->uriIdentifier));
        }

        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode));

        if (\is_string($this->referenceTypeCode)) {
            $element->appendChild($document->createElement('ram:ReferenceTypeCode', $this->referenceTypeCode));
        }

        if (\is_string($this->name)) {
            $element->appendChild($document->createElement('ram:Name', $this->name));
        }

        if ($this->attachmentBinaryObject instanceof BinaryObject) {
            $binaryObjectElement = $document->createElement('ram:AttachmentBinaryObject', $this->attachmentBinaryObject->content);

            $binaryObjectElement->setAttribute('mimeCode', $this->attachmentBinaryObject->mimeCode->value);
            $binaryObjectElement->setAttribute('filename', $this->attachmentBinaryObject->filename);

            $element->appendChild($binaryObjectElement);
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?static
    {
        $additionalReferencedDocumentInvoicedObjectIdentifierElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $additionalReferencedDocumentInvoicedObjectIdentifierElements->count()) {
            return null;
        }

        if ($additionalReferencedDocumentInvoicedObjectIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $additionalReferencedDocumentInvoicedObjectIdentifierElement */
        $additionalReferencedDocumentInvoicedObjectIdentifierElement = $additionalReferencedDocumentInvoicedObjectIdentifierElements->item(0);

        $issuerAssignedIdentifierElements = $xpath->query('.//ram:IssuerAssignedID', $additionalReferencedDocumentInvoicedObjectIdentifierElement);
        $uriIdentifierElements            = $xpath->query('.//ram:URIID', $additionalReferencedDocumentInvoicedObjectIdentifierElement);
        $typeCodeElements                 = $xpath->query('.//ram:TypeCode', $additionalReferencedDocumentInvoicedObjectIdentifierElement);
        $referenceTypeCodeElements        = $xpath->query('.//ram:ReferenceTypeCode', $additionalReferencedDocumentInvoicedObjectIdentifierElement);
        $nameElements                     = $xpath->query('.//ram:Name', $additionalReferencedDocumentInvoicedObjectIdentifierElement);
        $attachmentBinaryObjectElements   = $xpath->query('.//ram:AttachmentBinaryObject', $additionalReferencedDocumentInvoicedObjectIdentifierElement);

        if (1 !== $issuerAssignedIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($uriIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $typeCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($referenceTypeCodeElements->count() > 1) {
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

        if ('130' !== $typeCode) {
            throw new \Exception('Wrong TypeCode');
        }

        $additionalReferencedDocumentInvoicedObjectIdentifier = new static(new ObjectIdentifier($issuerAssignedIdentifier));

        if (1 === $uriIdentifierElements->count()) {
            $additionalReferencedDocumentInvoicedObjectIdentifier->setUriIdentifier($uriIdentifierElements->item(0)->nodeValue);
        }

        if (1 === $referenceTypeCodeElements->count()) {
            $additionalReferencedDocumentInvoicedObjectIdentifier->setReferenceTypeCode($referenceTypeCodeElements->item(0)->nodeValue);
        }

        if (1 === $nameElements->count()) {
            $additionalReferencedDocumentInvoicedObjectIdentifier->setName($nameElements->item(0)->nodeValue);
        }

        if (1 === $attachmentBinaryObjectElements->count()) {
            $attachmentBinaryObjectItem = $attachmentBinaryObjectElements->item(0);
            $content                    = $attachmentBinaryObjectItem->nodeValue;
            $mimeCode                   = MimeCode::tryFrom($attachmentBinaryObjectItem->getAttribute('mimeCode'));

            if (!$mimeCode instanceof MimeCode) {
                throw new \Exception('Wrong mimeCode');
            }

            $filename = $attachmentBinaryObjectItem->getAttribute('filename');

            $additionalReferencedDocumentInvoicedObjectIdentifier->setAttachmentBinaryObject(new BinaryObject($content, $mimeCode, $filename));
        }

        return $additionalReferencedDocumentInvoicedObjectIdentifier;
    }
}
