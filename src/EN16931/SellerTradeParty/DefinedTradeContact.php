<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\SellerTradeParty;

use Tiime\CrossIndustryInvoice\EN16931\EmailURIUniversalCommunication;
use Tiime\CrossIndustryInvoice\EN16931\TelephoneUniversalCommunication;

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
}
