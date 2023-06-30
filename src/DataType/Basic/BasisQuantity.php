<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Basic;

use Tiime\EN16931\BusinessTermsGroup\PriceDetails;
use Tiime\EN16931\DataType\UnitOfMeasurement;
use Tiime\EN16931\SemanticDataType\Quantity;

/**
 * BT-149-1 & BT-150-1.
 */
class BasisQuantity
{
    protected const XML_NODE = 'ram:BasisQuantity';

    /**
     * BT-149-1.
     */
    private Quantity $value;

    /**
     * BT-150-1.
     */
    private ?UnitOfMeasurement $unitCode;

    public function __construct(float $value)
    {
        $this->value    = new Quantity($value);
        $this->unitCode = null;
    }

    public function getValue(): float
    {
        return $this->value->getValue();
    }

    public function getUnitCode(): ?UnitOfMeasurement
    {
        return $this->unitCode;
    }

    public function setUnitCode(?UnitOfMeasurement $unitCode): static
    {
        $this->unitCode = $unitCode;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE, $this->value->getFormattedValueRounded());

        if ($this->unitCode instanceof UnitOfMeasurement) {
            $element->setAttribute('unitCode', $this->unitCode->value);
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $basisQuantityElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

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
            $unitCode = UnitOfMeasurement::tryFrom($basisQuantityElement->getAttribute('unitCode'));

            if (!$unitCode instanceof UnitOfMeasurement) {
                throw new \Exception('Wrong unitCode');
            }
        }

        $basisQuantity = new self((float) $value);

        if ($unitCode instanceof UnitOfMeasurement) {
            $basisQuantity->setUnitCode($unitCode);
        }

        return $basisQuantity;
    }

    public static function fromEN16931(PriceDetails $priceDetails): self
    {
        return (new self($priceDetails->getItemPriceBaseQuantity()))
            ->setUnitCode($priceDetails->getItemPriceBaseQuantityUnitOfMeasureCode());
    }
}
