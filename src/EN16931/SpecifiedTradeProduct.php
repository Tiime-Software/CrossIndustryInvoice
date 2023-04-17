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
    private ?StandardItemIdentifier $globalID;

    /**
     * BT-155.
     */
    private ?SellerItemIdentifier $sellerAssignedID;

    /**
     * BT-156.
     */
    private ?BuyerItemIdentifier $buyerAssignedID;

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
        $this->globalID                         = null;
        $this->sellerAssignedID                 = null;
        $this->buyerAssignedID                  = null;
        $this->description                      = null;
        $this->originTradeCountry               = null;
        $this->applicableProductCharacteristics = [];
        $this->designatedProductClassifications = [];
    }

    public function getGlobalID(): ?StandardItemIdentifier
    {
        return $this->globalID;
    }

    public function setGlobalID(?StandardItemIdentifier $globalID): void
    {
        $this->globalID = $globalID;
    }

    public function getSellerAssignedID(): ?SellerItemIdentifier
    {
        return $this->sellerAssignedID;
    }

    public function setSellerAssignedID(?SellerItemIdentifier $sellerAssignedID): void
    {
        $this->sellerAssignedID = $sellerAssignedID;
    }

    public function getBuyerAssignedID(): ?BuyerItemIdentifier
    {
        return $this->buyerAssignedID;
    }

    public function setBuyerAssignedID(?BuyerItemIdentifier $buyerAssignedID): void
    {
        $this->buyerAssignedID = $buyerAssignedID;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getApplicableProductCharacteristics(): array
    {
        return $this->applicableProductCharacteristics;
    }

    public function setApplicableProductCharacteristics(array $applicableProductCharacteristics): void
    {
        $tmpApplicableProductCharacteristics = [];

        foreach ($applicableProductCharacteristics as $applicableProductCharacteristic) {
            if (!$applicableProductCharacteristic instanceof ApplicableProductCharacteristic) {
                throw new \TypeError();
            }

            $tmpApplicableProductCharacteristics[] = $applicableProductCharacteristic;
        }

        $this->applicableProductCharacteristics = $tmpApplicableProductCharacteristics;
    }

    public function getDesignatedProductClassifications(): array
    {
        return $this->designatedProductClassifications;
    }

    public function setDesignatedProductClassifications(array $designatedProductClassifications): void
    {
        $tmpDesignatedProductClassifications = [];

        foreach ($designatedProductClassifications as $designatedProductClassification) {
            if (!$designatedProductClassification instanceof DesignatedProductClassification) {
                throw new \TypeError();
            }

            $tmpDesignatedProductClassifications[] = $designatedProductClassification;
        }

        $this->designatedProductClassifications = $tmpDesignatedProductClassifications;
    }

    public function getOriginTradeCountry(): ?OriginTradeCountry
    {
        return $this->originTradeCountry;
    }

    public function setOriginTradeCountry(?OriginTradeCountry $originTradeCountry): void
    {
        $this->originTradeCountry = $originTradeCountry;
    }
}
