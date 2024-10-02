<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\BusinessTermsGroup\AdditionalSupportingDocument;
use Tiime\EN16931\DataType\BinaryObject;
use Tiime\EN16931\DataType\MimeCode;
use Tiime\EN16931\DataType\Reference\SupportingDocumentReference;

/**
 * BG-24.
 */
class AdditionalReferencedDocumentAdditionalSupportingDocument
{
    protected const XML_NODE = 'ram:AdditionalReferencedDocument';

    /**
     * BT-122.
     */
    private SupportingDocumentReference $issuerAssignedIdentifier;

    /**
     * BT-124.
     */
    private ?string $uriIdentifier;

    /**
     * BT-122-0.
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

    public function __construct(SupportingDocumentReference $issuerAssignedIdentifier)
    {
        $this->issuerAssignedIdentifier = $issuerAssignedIdentifier;
        $this->typeCode                 = '916';
        $this->uriIdentifier            = null;
        $this->name                     = null;
        $this->attachmentBinaryObject   = null;
    }

    public function getIssuerAssignedIdentifier(): SupportingDocumentReference
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

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        $additionalReferencedDocumentElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $additionalReferencedDocumentElements->count()) {
            return [];
        }

        $additionalReferencedDocuments = [];

        foreach ($additionalReferencedDocumentElements as $additionalReferencedDocumentElement) {
            $issuerAssignedIdentifierElements = $xpath->query('./ram:IssuerAssignedID', $additionalReferencedDocumentElement);
            $uriIdentifierElements            = $xpath->query('./ram:URIID', $additionalReferencedDocumentElement);
            $typeCodeElements                 = $xpath->query('./ram:TypeCode', $additionalReferencedDocumentElement);
            $nameElements                     = $xpath->query('./ram:Name', $additionalReferencedDocumentElement);
            $attachmentBinaryObjectElements   = $xpath->query('./ram:AttachmentBinaryObject', $additionalReferencedDocumentElement);

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

            if ('916' !== $typeCode) {
                throw new \Exception('Wrong TypeCode');
            }

            $additionalReferencedDocument = new self(new SupportingDocumentReference($issuerAssignedIdentifier));

            if (1 === $uriIdentifierElements->count()) {
                $additionalReferencedDocument->setUriIdentifier($uriIdentifierElements->item(0)->nodeValue);
            }

            if (1 === $nameElements->count()) {
                $additionalReferencedDocument->setName($nameElements->item(0)->nodeValue);
            }

            if (1 === $attachmentBinaryObjectElements->count()) {
                $attachmentBinaryObjectItem = $attachmentBinaryObjectElements->item(0);
                $content                    = $attachmentBinaryObjectItem->nodeValue;

                $mimeCode = MimeCode::tryFrom($attachmentBinaryObjectItem->getAttribute('mimeCode'));

                if (!$mimeCode instanceof MimeCode) {
                    throw new \Exception('Wrong mimeCode');
                }

                $filename = $attachmentBinaryObjectItem->getAttribute('filename');

                $additionalReferencedDocument->setAttachmentBinaryObject(new BinaryObject($content, $mimeCode, $filename));
            }

            $additionalReferencedDocuments[] = $additionalReferencedDocument;
        }

        return $additionalReferencedDocuments;
    }

    public static function fromEN16931(AdditionalSupportingDocument $additionalSupportingDocument): self
    {
        return (new self($additionalSupportingDocument->getReference()))
            ->setName($additionalSupportingDocument->getDescription())
            ->setUriIdentifier($additionalSupportingDocument->getExternalDocumentLocation())
            ->setAttachmentBinaryObject($additionalSupportingDocument->getAttachedDocument());
    }
}
