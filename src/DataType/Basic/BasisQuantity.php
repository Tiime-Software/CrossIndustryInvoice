<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\Codelist\UnitOfMeasureCode;
use Tiime\EN16931\SemanticDataType\Quantity;

/**
 * BT-149-1 & BT-150-1.
 */
class BasisQuantity
{
    protected const string XML_NODE = 'ram:BasisQuantity';

    /**
     * BT-149-1.
     */
    private Quantity $value;

    /**
     * BT-150-1.
     */
    private ?UnitOfMeasureCode $unitCode;

    public function __construct(float $value)
    {
        $this->value    = new Quantity($value);
        $this->unitCode = null;
    }

    public function getValue(): Quantity
    {
        return $this->value;
    }

    public function getUnitCode(): ?UnitOfMeasureCode
    {
        return $this->unitCode;
    }

    public function setUnitCode(?UnitOfMeasureCode $unitCode): static
    {
        $this->unitCode = $unitCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE, $this->value->getFormattedValueRounded());

        if ($this->unitCode instanceof UnitOfMeasureCode) {
            $element->setAttribute('unitCode', $this->unitCode->value);
        }

        return $element;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): ?self
    {
        $basisQuantityElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $basisQuantityElements->count()) {
            return null;
        }

        if ($basisQuantityElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $basisQuantityElement */
        $basisQuantityElement = $basisQuantityElements->item(0);

        $value = $basisQuantityElement->nodeValue;

        $unitCode = null;

        if ('' !== $basisQuantityElement->getAttribute('unitCode')) {
            $unitCode = UnitOfMeasureCode::tryFrom($basisQuantityElement->getAttribute('unitCode'));

            if (!$unitCode instanceof UnitOfMeasureCode) {
                throw new \Exception('Wrong unitCode');
            }
        }

        $basisQuantity = new self((float) $value);

        if ($unitCode instanceof UnitOfMeasureCode) {
            $basisQuantity->setUnitCode($unitCode);
        }

        return $basisQuantity;
    }
}
