<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\BuyerTradeParty;

use Tiime\CrossIndustryInvoice\DataType\EmailURIUniversalCommunication;
use Tiime\CrossIndustryInvoice\EN16931\TelephoneUniversalCommunication;

/**
 * BG-9.
 */
class DefinedTradeContact
{
    /**
     * BT-56.
     */
    private ?string $personName;

    /**
     * BT-56-0.
     */
    private ?string $departmentName;

    /**
     * BT-57-00.
     */
    private ?TelephoneUniversalCommunication $telephoneUniversalCommunication;

    /**
     * BT-58-00.
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

    public function setPersonName(?string $personName): void
    {
        $this->personName = $personName;
    }

    public function getDepartmentName(): ?string
    {
        return $this->departmentName;
    }

    public function setDepartmentName(?string $departmentName): void
    {
        $this->departmentName = $departmentName;
    }

    public function getTelephoneUniversalCommunication(): ?TelephoneUniversalCommunication
    {
        return $this->telephoneUniversalCommunication;
    }

    public function setTelephoneUniversalCommunication(?TelephoneUniversalCommunication $telephoneUniversalCommunication): void
    {
        $this->telephoneUniversalCommunication = $telephoneUniversalCommunication;
    }

    public function getEmailURIUniversalCommunication(): ?EmailURIUniversalCommunication
    {
        return $this->emailURIUniversalCommunication;
    }

    public function setEmailURIUniversalCommunication(?EmailURIUniversalCommunication $emailURIUniversalCommunication): void
    {
        $this->emailURIUniversalCommunication = $emailURIUniversalCommunication;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:DefinedTradeContact');

        if (is_string($this->personName)) {
            $element->appendChild($document->createElement('ram:PersonName', $this->personName));
        }

        if (is_string($this->departmentName)) {
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
}
