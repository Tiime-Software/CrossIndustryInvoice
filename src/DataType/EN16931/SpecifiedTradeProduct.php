<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\ApplicableProductCharacteristic;
use Tiime\CrossIndustryInvoice\EN16931\ClassCode;
use Tiime\CrossIndustryInvoice\EN16931\DesignatedProductClassification;
use Tiime\CrossIndustryInvoice\EN16931\OriginTradeCountry;
use Tiime\EN16931\BusinessTermsGroup\ItemInformation;
use Tiime\EN16931\DataType\Identifier\BuyerItemIdentifier;
use Tiime\EN16931\DataType\Identifier\SellerItemIdentifier;
use Tiime\EN16931\DataType\Identifier\StandardItemIdentifier;

/**
 * BG-31.
 */
class SpecifiedTradeProduct extends \Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeProduct
{
    /**
     * BT-155.
     */
    private ?SellerItemIdentifier $sellerAssignedIdentifier;

    /**
     * BT-156.
     */
    private ?BuyerItemIdentifier $buyerAssignedIdentifier;

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
        parent::__construct($name);

        $this->sellerAssignedIdentifier         = null;
        $this->buyerAssignedIdentifier          = null;
        $this->description                      = null;
        $this->originTradeCountry               = null;
        $this->applicableProductCharacteristics = [];
        $this->designatedProductClassifications = [];
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

        if ($this->getGlobalIdentifier() instanceof StandardItemIdentifier) {
            $identifierElement = $document->createElement('ram:GlobalID', $this->getGlobalIdentifier()->value);
            $identifierElement->setAttribute('schemeID', $this->getGlobalIdentifier()->scheme->value);

            $element->appendChild($identifierElement);
        }

        if ($this->sellerAssignedIdentifier instanceof SellerItemIdentifier) {
            $element->appendChild($document->createElement('ram:SellerAssignedID', $this->sellerAssignedIdentifier->value));
        }

        if ($this->buyerAssignedIdentifier instanceof BuyerItemIdentifier) {
            $element->appendChild($document->createElement('ram:BuyerAssignedID', $this->buyerAssignedIdentifier->value));
        }

        $element->appendChild($document->createElement('ram:Name', $this->getName()));

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

    public static function fromEN16931(ItemInformation $itemInformation): static
    {
        $characteristics = [];
        $classifications = [];

        foreach ($itemInformation->getItemAttributes() as $attribute) {
            $characteristics[] = new ApplicableProductCharacteristic($attribute->getName(), $attribute->getValue());
        }

        foreach ($itemInformation->getClassificationIdentifiers() as $classificationIdentifier) {
            $classCode = (new ClassCode($classificationIdentifier->value, $classificationIdentifier->scheme))
                ->setListVersionIdentifier($classificationIdentifier->version);

            $classifications[] = (new DesignatedProductClassification())->setClassCode($classCode);
        }

        return (new self($itemInformation->getName()))
            ->setGlobalIdentifier($itemInformation->getStandardIdentifier())
            ->setSellerAssignedIdentifier($itemInformation->getSellerIdentifier())
            ->setBuyerAssignedIdentifier($itemInformation->getBuyerIdentifier())
            ->setDescription($itemInformation->getDescription())
            ->setApplicableProductCharacteristics($characteristics)
            ->setDesignatedProductClassifications($classifications)
            ->setOriginTradeCountry($itemInformation->getItemCountryOfOrigin());
    }
}
