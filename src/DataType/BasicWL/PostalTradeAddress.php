<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\EN16931\DataType\CountryAlpha2Code;

/**
 * BG-5.
 */
class PostalTradeAddress extends \Tiime\CrossIndustryInvoice\DataType\Minimum\PostalTradeAddress
{
    /**
     * BT-38.
     */
    private ?string $postcodeCode;

    /**
     * BT-35.
     */
    private ?string $lineOne;

    /**
     * BT-36.
     */
    private ?string $lineTwo;

    /**
     * BT-162.
     */
    private ?string $lineThree;

    /**
     * BT-37.
     */
    private ?string $cityName;

    /**
     * BT-39.
     */
    private ?string $countrySubDivisionName;

    public function __construct(CountryAlpha2Code $countryID)
    {
        parent::__construct($countryID);
        $this->postcodeCode           = null;
        $this->lineOne                = null;
        $this->lineTwo                = null;
        $this->lineThree              = null;
        $this->cityName               = null;
        $this->countrySubDivisionName = null;
    }

    public function getPostcodeCode(): ?string
    {
        return $this->postcodeCode;
    }

    public function setPostcodeCode(?string $postcodeCode): void
    {
        $this->postcodeCode = $postcodeCode;
    }

    public function getLineOne(): ?string
    {
        return $this->lineOne;
    }

    public function setLineOne(?string $lineOne): void
    {
        $this->lineOne = $lineOne;
    }

    public function getLineTwo(): ?string
    {
        return $this->lineTwo;
    }

    public function setLineTwo(?string $lineTwo): void
    {
        $this->lineTwo = $lineTwo;
    }

    public function getLineThree(): ?string
    {
        return $this->lineThree;
    }

    public function setLineThree(?string $lineThree): void
    {
        $this->lineThree = $lineThree;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(?string $cityName): void
    {
        $this->cityName = $cityName;
    }

    public function getCountrySubDivisionName(): ?string
    {
        return $this->countrySubDivisionName;
    }

    public function setCountrySubDivisionName(?string $countrySubDivisionName): void
    {
        $this->countrySubDivisionName = $countrySubDivisionName;
    }
}