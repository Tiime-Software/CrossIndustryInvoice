<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;

use Tiime\CrossIndustryInvoice\DataType\EmailURIUniversalCommunication;
use Tiime\CrossIndustryInvoice\EN16931\TelephoneUniversalCommunication;
use Tiime\EN16931\BusinessTermsGroup\SellerContact;

/**
 * BG-6.
 */
class DefinedTradeContact
{
    /**
     * BT-41.
     */
    private ?string $personName;

    /**
     * BT-41-0.
     */
    private ?string $departmentName;

    /**
     * BT-42-00.
     */
    private ?TelephoneUniversalCommunication $telephoneUniversalCommunication;

    /**
     * BT-43-00.
     */
    private ?EmailURIUniversalCommunication $emailURIUniversalCommunication;

    public function __construct()
    {
        $this->personName                      = null;
        $this->departmentName                  = null;
        $this->telephoneUniversalCommunication = null;
        $this->emailURIUniversalCommunication  = null;
    }

    public function getPersonName(): ?string
    {
        return $this->personName;
    }

    public function setPersonName(?string $personName): static
    {
        $this->personName = $personName;

        return $this;
    }

    public function getDepartmentName(): ?string
    {
        return $this->departmentName;
    }

    public function setDepartmentName(?string $departmentName): static
    {
        $this->departmentName = $departmentName;

        return $this;
    }

    public function getTelephoneUniversalCommunication(): ?TelephoneUniversalCommunication
    {
        return $this->telephoneUniversalCommunication;
    }

    public function setTelephoneUniversalCommunication(?TelephoneUniversalCommunication $telephoneUniversalCommunication): static
    {
        $this->telephoneUniversalCommunication = $telephoneUniversalCommunication;

        return $this;
    }

    public function getEmailURIUniversalCommunication(): ?EmailURIUniversalCommunication
    {
        return $this->emailURIUniversalCommunication;
    }

    public function setEmailURIUniversalCommunication(?EmailURIUniversalCommunication $emailURIUniversalCommunication): static
    {
        $this->emailURIUniversalCommunication = $emailURIUniversalCommunication;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:DefinedTradeContact');

        if (\is_string($this->personName)) {
            $element->appendChild($document->createElement('ram:PersonName', $this->personName));
        }

        if (\is_string($this->departmentName)) {
            $element->appendChild($document->createElement('ram:DepartmentName', $this->departmentName));
        }

        if ($this->telephoneUniversalCommunication instanceof TelephoneUniversalCommunication) {
            $element->appendChild($this->telephoneUniversalCommunication->toXML($document));
        }

        if ($this->emailURIUniversalCommunication instanceof EmailURIUniversalCommunication) {
            $element->appendChild($this->emailURIUniversalCommunication->toXML($document));
        }

        return $element;
    }

    public static function fromEN16931(SellerContact $contact): static
    {
        return (new self())
            ->setPersonName($contact->getPoint())
            ->setDepartmentName($contact->getPoint())
            ->setTelephoneUniversalCommunication(new TelephoneUniversalCommunication($contact->getPhoneNumber()))
            ->setEmailURIUniversalCommunication(new EmailURIUniversalCommunication($contact->getEmail()));
    }
}
