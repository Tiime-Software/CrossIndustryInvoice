<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\EN16931\DataType\Identifier\BuyerItemIdentifier;
use Tiime\EN16931\DataType\Identifier\SellerItemIdentifier;
use Tiime\EN16931\DataType\Identifier\StandardItemIdentifier;

/**
 * BG-31.
 */
class SpecifiedTradeProduct
{
    /**
     * BT-157.
     */
    private ?StandardItemIdentifier $globalIdentifier;

    /**
     * BT-155.
     */
    private ?SellerItemIdentifier $sellerAssignedIdentifier;

    /**
     * BT-156.
     */
    private ?BuyerItemIdentifier $buyerAssignedIdentifier;

    /**
     * BT-153.
     */
    private string $name;

    /**
     * BT-154.
     */
    private ?string $description;

    /**
     * BG-32.
     *
     * @var array<int, ApplicableProductCharacteristic>
     */
    private array $applicableProductCharacteristics;

    /**
     * BT-158-00.
     *
     * @var array<int, DesignatedProductClassification>
     */
    private array $designatedProductClassifications;

    /**
     * BT-159-00.
     */
    private ?OriginTradeCountry $originTradeCountry;

    public function __construct(string $name)
    {
        $this->name                             = $name;
        $this->globalIdentifier                 = null;
        $this->sellerAssignedIdentifier         = null;
        $this->buyerAssignedIdentifier          = null;
        $this->description                      = null;
        $this->originTradeCountry               = null;
        $this->applicableProductCharacteristics = [];
        $this->designatedProductClassifications = [];
    }

    public function getGlobalIdentifier(): ?StandardItemIdentifier
    {
        return $this->globalIdentifier;
    }

    public function setGlobalIdentifier(?StandardItemIdentifier $globalIdentifier): static
    {
        $this->globalIdentifier = $globalIdentifier;

        return $this;
    }

    public function getSellerAssignedIdentifier(): ?SellerItemIdentifier
    {
        return $this->sellerAssignedIdentifier;
    }

    public function setSellerAssignedIdentifier(?SellerItemIdentifier $sellerAssignedIdentifier): static
    {
        $this->sellerAssignedIdentifier = $sellerAssignedIdentifier;

        return $this;
    }

    public function getBuyerAssignedIdentifier(): ?BuyerItemIdentifier
    {
        return $this->buyerAssignedIdentifier;
    }

    public function setBuyerAssignedIdentifier(?BuyerItemIdentifier $buyerAssignedIdentifier): static
    {
        $this->buyerAssignedIdentifier = $buyerAssignedIdentifier;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getApplicableProductCharacteristics(): array
    {
        return $this->applicableProductCharacteristics;
    }

    public function setApplicableProductCharacteristics(array $applicableProductCharacteristics): static
    {
        $tmpApplicableProductCharacteristics = [];

        foreach ($applicableProductCharacteristics as $applicableProductCharacteristic) {
            if (!$applicableProductCharacteristic instanceof ApplicableProductCharacteristic) {
                throw new \TypeError();
            }

            $tmpApplicableProductCharacteristics[] = $applicableProductCharacteristic;
        }

        $this->applicableProductCharacteristics = $tmpApplicableProductCharacteristics;

        return $this;
    }

    public function getDesignatedProductClassifications(): array
    {
        return $this->designatedProductClassifications;
    }

    public function setDesignatedProductClassifications(array $designatedProductClassifications): static
    {
        $tmpDesignatedProductClassifications = [];

        foreach ($designatedProductClassifications as $designatedProductClassification) {
            if (!$designatedProductClassification instanceof DesignatedProductClassification) {
                throw new \TypeError();
            }

            $tmpDesignatedProductClassifications[] = $designatedProductClassification;
        }

        $this->designatedProductClassifications = $tmpDesignatedProductClassifications;

        return $this;
    }

    public function getOriginTradeCountry(): ?OriginTradeCountry
    {
        return $this->originTradeCountry;
    }

    public function setOriginTradeCountry(?OriginTradeCountry $originTradeCountry): static
    {
        $this->originTradeCountry = $originTradeCountry;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTradeProduct');

        if ($this->globalIdentifier instanceof StandardItemIdentifier) {
            $identifierElement = $document->createElement('ram:GlobalID', $this->globalIdentifier->value);
            $identifierElement->setAttribute('schemeID', $this->globalIdentifier->scheme->value);

            $element->appendChild($identifierElement);
        }

        if ($this->sellerAssignedIdentifier instanceof SellerItemIdentifier) {
            $element->appendChild($document->createElement('ram:SellerAssignedID', $this->sellerAssignedIdentifier->value));
        }

        if ($this->buyerAssignedIdentifier instanceof BuyerItemIdentifier) {
            $element->appendChild($document->createElement('ram:BuyerAssignedID', $this->buyerAssignedIdentifier->value));
        }

        $element->appendChild($document->createElement('ram:Name', $this->name));

        if (\is_string($this->description)) {
            $element->appendChild($document->createElement('ram:Description', $this->description));
        }

        foreach ($this->applicableProductCharacteristics as $applicableProductCharacteristic) {
            $element->appendChild($applicableProductCharacteristic->toXML($document));
        }

        foreach ($this->designatedProductClassifications as $designatedProductClassification) {
            $element->appendChild($designatedProductClassification->toXML($document));
        }

        if ($this->originTradeCountry instanceof OriginTradeCountry) {
            $element->appendChild($this->originTradeCountry->toXML($document));
        }

        return $element;
    }
}
