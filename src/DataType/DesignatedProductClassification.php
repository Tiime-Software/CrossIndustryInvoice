<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-158-00.
 */
class DesignatedProductClassification
{
    protected const XML_NODE = 'ram:DesignatedProductClassification';

    /**
     * BT-158 & BT-158-1 & BT-158-2.
     */
    private ?ClassCode $classCode;

    public function __construct()
    {
    }

    public function getClassCode(): ?ClassCode
    {
        return $this->classCode;
    }

    public function setClassCode(?ClassCode $classCode): static
    {
        $this->classCode = $classCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if ($this->classCode instanceof ClassCode) {
            $currentNode->appendChild($this->classCode->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): array
    {
        $designatedProductClassificationElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $designatedProductClassificationElements->count()) {
            return [];
        }

        $designatedProductClassifications = [];

        foreach ($designatedProductClassificationElements as $designatedProductClassificationElement) {
            $classCode = ClassCode::fromXML($xpath, $designatedProductClassificationElement);

            $designatedProductClassification = new self();

            if ($classCode instanceof ClassCode) {
                $designatedProductClassification->setClassCode($classCode);
            }

            $designatedProductClassifications[] = $designatedProductClassification;
        }

        return $designatedProductClassifications;
    }
}
