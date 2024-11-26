<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\Codelist\TextSubjectCodeUNTDID4451;

/**
 * BG-1.
 */
class DocumentIncludedNote
{
    protected const string XML_NODE = 'ram:IncludedNote';

    /**
     * BT-21.
     */
    private ?TextSubjectCodeUNTDID4451 $subjectCode;

    /**
     * @param string $content - BT-22
     */
    public function __construct(
        private readonly string $content,
    ) {
        $this->subjectCode = null;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSubjectCode(): ?TextSubjectCodeUNTDID4451
    {
        return $this->subjectCode;
    }

    public function setSubjectCode(?TextSubjectCodeUNTDID4451 $subjectCode): static
    {
        $this->subjectCode = $subjectCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($document->createElement('ram:Content', $this->content));

        if ($this->subjectCode instanceof TextSubjectCodeUNTDID4451) {
            $currentNode->appendChild($document->createElement('ram:SubjectCode', $this->subjectCode->value));
        }

        return $currentNode;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): array
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
                $subjectCode = TextSubjectCodeUNTDID4451::tryFrom($subjectCodeElements->item(0)->nodeValue);

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
