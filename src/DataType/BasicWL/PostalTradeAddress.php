<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\EN16931\DataType\Address;
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

    public function setPostcodeCode(?string $postcodeCode): static
    {
        $this->postcodeCode = $postcodeCode;

        return $this;
    }

    public function getLineOne(): ?string
    {
        return $this->lineOne;
    }

    public function setLineOne(?string $lineOne): static
    {
        $this->lineOne = $lineOne;

        return $this;
    }

    public function getLineTwo(): ?string
    {
        return $this->lineTwo;
    }

    public function setLineTwo(?string $lineTwo): static
    {
        $this->lineTwo = $lineTwo;

        return $this;
    }

    public function getLineThree(): ?string
    {
        return $this->lineThree;
    }

    public function setLineThree(?string $lineThree): static
    {
        $this->lineThree = $lineThree;

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(?string $cityName): static
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getCountrySubDivisionName(): ?string
    {
        return $this->countrySubDivisionName;
    }

    public function setCountrySubDivisionName(?string $countrySubDivisionName): static
    {
        $this->countrySubDivisionName = $countrySubDivisionName;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        if (\is_string($this->postcodeCode)) {
            $currentNode->appendChild($document->createElement('ram:PostcodeCode', $this->postcodeCode));
        }

        if (\is_string($this->lineOne)) {
            $currentNode->appendChild($document->createElement('ram:LineOne', $this->lineOne));
        }

        if (\is_string($this->lineTwo)) {
            $currentNode->appendChild($document->createElement('ram:LineTwo', $this->lineTwo));
        }

        if (\is_string($this->lineThree)) {
            $currentNode->appendChild($document->createElement('ram:LineThree', $this->lineThree));
        }

        if (\is_string($this->cityName)) {
            $currentNode->appendChild($document->createElement('ram:CityName', $this->cityName));
        }

        $currentNode->appendChild($document->createElement('ram:CountryID', $this->countryIdentifier->value));

        if (\is_string($this->countrySubDivisionName)) {
            $currentNode->appendChild($document->createElement('ram:CountrySubDivisionName', $this->countrySubDivisionName));
        }

        return $currentNode;
    }

    /**
     * PostalTradeAddress is mandatory everywhere except for "ShipToTradeParty" which is optional
     * BasicWL\PostalTradeAddress have to return ?static
     * Because of the heritage, Minimum\PostalTradeAddress have to return ?static too.
     */
    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $postalTradeAddressElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (1 !== $postalTradeAddressElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $postalTradeAddressElement */
        $postalTradeAddressElement = $postalTradeAddressElements->item(0);

        $postcodeCodeElements           = $xpath->query('.//ram:PostcodeCode', $postalTradeAddressElement);
        $lineOneElements                = $xpath->query('.//ram:LineOne', $postalTradeAddressElement);
        $lineTwoElements                = $xpath->query('.//ram:LineTwo', $postalTradeAddressElement);
        $lineThreeElements              = $xpath->query('.//ram:LineThree', $postalTradeAddressElement);
        $cityNameElements               = $xpath->query('.//ram:CityName', $postalTradeAddressElement);
        $countryIdentifierElements      = $xpath->query('.//ram:CountryID', $postalTradeAddressElement);
        $countrySubDivisionNameElements = $xpath->query('.//ram:CountrySubDivisionName', $postalTradeAddressElement);

        if ($postcodeCodeElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($lineOneElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($lineTwoElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($lineThreeElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($cityNameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $countryIdentifierElements->count()) {
            throw new \Exception('Malformed');
        }

        if ($countrySubDivisionNameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $countryIdentifier = CountryAlpha2Code::tryFrom($countryIdentifierElements->item(0)->nodeValue);

        if (null === $countryIdentifier) {
            throw new \Exception('Wrong CountryID');
        }

        $postalTradeAddress = new self($countryIdentifier);

        if (1 === $postcodeCodeElements->count()) {
            $postalTradeAddress->setPostcodeCode($postcodeCodeElements->item(0)->nodeValue);
        }

        if (1 === $lineOneElements->count()) {
            $postalTradeAddress->setLineOne($lineOneElements->item(0)->nodeValue);
        }

        if (1 === $lineTwoElements->count()) {
            $postalTradeAddress->setLineTwo($lineTwoElements->item(0)->nodeValue);
        }

        if (1 === $lineThreeElements->count()) {
            $postalTradeAddress->setLineThree($lineThreeElements->item(0)->nodeValue);
        }

        if (1 === $cityNameElements->count()) {
            $postalTradeAddress->setCityName($cityNameElements->item(0)->nodeValue);
        }

        if (1 === $countrySubDivisionNameElements->count()) {
            $postalTradeAddress->setCountrySubDivisionName($countrySubDivisionNameElements->item(0)->nodeValue);
        }

        return $postalTradeAddress;
    }

    public static function fromEN16931(Address $address): self
    {
        return (new self($address->getCountryCode()))
            ->setPostcodeCode($address->getPostCode())
            ->setLineOne($address->getLine1())
            ->setLineTwo($address->getLine2())
            ->setLineThree($address->getLine3())
            ->setCityName($address->getCity())
            ->setCountrySubDivisionName($address->getCountrySubdivision());
    }
}
