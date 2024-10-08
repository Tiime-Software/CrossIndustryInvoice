<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BG-9 or BG-6.
 */
class DefinedTradeContact
{
    protected const string XML_NODE = 'ram:DefinedTradeContact';

    /**
     * BT-56 or BT-41.
     */
    private ?string $personName;

    /**
     * BT-56-0 or BT-41-0.
     */
    private ?string $departmentName;

    /**
     * BT-57-00 or BT-42-00.
     */
    private ?TelephoneUniversalCommunication $telephoneUniversalCommunication;

    /**
     * BT-58-00 or BT-43-00.
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
        $currentNode = $document->createElement(self::XML_NODE);

        if (\is_string($this->personName)) {
            $currentNode->appendChild($document->createElement('ram:PersonName', $this->personName));
        }

        if (\is_string($this->departmentName)) {
            $currentNode->appendChild($document->createElement('ram:DepartmentName', $this->departmentName));
        }

        if ($this->telephoneUniversalCommunication instanceof TelephoneUniversalCommunication) {
            $currentNode->appendChild($this->telephoneUniversalCommunication->toXML($document));
        }

        if ($this->emailURIUniversalCommunication instanceof EmailURIUniversalCommunication) {
            $currentNode->appendChild($this->emailURIUniversalCommunication->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $definedTradeContactElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $definedTradeContactElements->count()) {
            return null;
        }

        if ($definedTradeContactElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $definedTradeContactElement */
        $definedTradeContactElement = $definedTradeContactElements->item(0);

        $personNameElements     = $xpath->query('./ram:PersonName', $definedTradeContactElement);
        $departmentNameElements = $xpath->query('./ram:DepartmentName', $definedTradeContactElement);

        if ($personNameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if ($departmentNameElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        $telephoneUniversalCommunication = TelephoneUniversalCommunication::fromXML($xpath, $definedTradeContactElement);
        $emailURIUniversalCommunication  = EmailURIUniversalCommunication::fromXML($xpath, $definedTradeContactElement);

        $definedTradeContact = new self();

        if (1 === $personNameElements->count()) {
            $definedTradeContact->setPersonName($personNameElements->item(0)->nodeValue);
        }

        if (1 === $departmentNameElements->count()) {
            $definedTradeContact->setDepartmentName($departmentNameElements->item(0)->nodeValue);
        }

        if ($telephoneUniversalCommunication instanceof TelephoneUniversalCommunication) {
            $definedTradeContact->setTelephoneUniversalCommunication($telephoneUniversalCommunication);
        }

        if ($emailURIUniversalCommunication instanceof EmailURIUniversalCommunication) {
            $definedTradeContact->setEmailURIUniversalCommunication($emailURIUniversalCommunication);
        }

        return $definedTradeContact;
    }
}
