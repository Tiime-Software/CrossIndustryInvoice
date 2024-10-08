<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\InvoiceNoteCode;

/**
 * BG-1.
 */
class DocumentIncludedNote
{
    protected const string XML_NODE = 'ram:IncludedNote';

    /**
     * BT-21.
     */
    private ?InvoiceNoteCode $subjectCode;

    /**
     * @param string $content - BT-22
     */
    public function __construct(
        private string $content,
    ) {
        $this->subjectCode = null;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSubjectCode(): ?InvoiceNoteCode
    {
        return $this->subjectCode;
    }

    public function setSubjectCode(?InvoiceNoteCode $subjectCode): static
    {
        $this->subjectCode = $subjectCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:Content', $this->content));

        if ($this->subjectCode instanceof InvoiceNoteCode) {
            $currentNode->appendChild($document->createElement('ram:SubjectCode', $this->subjectCode->value));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        $documentIncludedNoteElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $documentIncludedNoteElements->count()) {
            return [];
        }

        $documentIncludedNotes = [];

        foreach ($documentIncludedNoteElements as $documentIncludedNoteElement) {
            $contentElements     = $xpath->query('./ram:Content', $documentIncludedNoteElement);
            $subjectCodeElements = $xpath->query('./ram:SubjectCode', $documentIncludedNoteElement);

            if (1 !== $contentElements->count()) {
                throw new \Exception('Malformed');
            }

            if ($subjectCodeElements->count() > 1) {
                throw new \Exception('Malformed');
            }

            $content = $contentElements->item(0)->nodeValue;

            $documentIncludedNote = new self($content);

            if (1 === $subjectCodeElements->count()) {
                $subjectCode = InvoiceNoteCode::tryFrom($subjectCodeElements->item(0)->nodeValue);

                if (null === $subjectCode) {
                    throw new \Exception('Wrong SubjectCode');
                }

                $documentIncludedNote->setSubjectCode($subjectCode);
            }

            $documentIncludedNotes[] = $documentIncludedNote;
        }

        return $documentIncludedNotes;
    }
}
