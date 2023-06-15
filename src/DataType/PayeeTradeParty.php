<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeeSpecifiedLegalOrganization;
use Tiime\EN16931\BusinessTermsGroup\Payee;
use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\PayeeIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BG-10.
 */
class PayeeTradeParty
{
    protected const XML_NODE = 'ram:PayeeTradeParty';

    /**
     * BT-60.
     */
    private ?PayeeIdentifier $identifier;

    /**
     * BT-60-0 & BT-60-1.
     */
    private ?PayeeGlobalIdentifier $globalIdentifier;

    /**
     * BT-59.
     */
    private string $name;

    /**
     * BT-61-00.
     */
    private ?PayeeSpecifiedLegalOrganization $specifiedLegalOrganization;

    public function __construct(string $name)
    {
        $this->name                       = $name;
        $this->identifier                 = null;
        $this->globalIdentifier           = null;
        $this->specifiedLegalOrganization = null;
    }

    public function getIdentifier(): ?PayeeIdentifier
    {
        return $this->identifier;
    }

    public function setIdentifier(?PayeeIdentifier $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getGlobalIdentifier(): ?PayeeGlobalIdentifier
    {
        return $this->globalIdentifier;
    }

    public function setGlobalIdentifier(?PayeeGlobalIdentifier $globalIdentifier): static
    {
        $this->globalIdentifier = $globalIdentifier;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpecifiedLegalOrganization(): ?PayeeSpecifiedLegalOrganization
    {
        return $this->specifiedLegalOrganization;
    }

    public function setSpecifiedLegalOrganization(?PayeeSpecifiedLegalOrganization $specifiedLegalOrganization): static
    {
        $this->specifiedLegalOrganization = $specifiedLegalOrganization;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        if ($this->identifier instanceof PayeeIdentifier) {
            $element->appendChild($document->createElement('ram:ID', $this->identifier->value));
        }

        if ($this->globalIdentifier instanceof PayeeGlobalIdentifier) {
            $globalIdentifierElement = $document->createElement('ram:GlobalID', $this->globalIdentifier->value);
            $globalIdentifierElement->setAttribute('schemeID', $this->globalIdentifier->scheme->value);
            $element->appendChild($globalIdentifierElement);
        }

        $element->appendChild($document->createElement('ram:Name', $this->name));

        if ($this->specifiedLegalOrganization instanceof PayeeSpecifiedLegalOrganization) {
            $element->appendChild($this->specifiedLegalOrganization->toXML($document));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $payeeTradePartyElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $payeeTradePartyElements->count()) {
            return null;
        }

        if ($payeeTradePartyElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $payeeTradePartyElement */
        $payeeTradePartyElement = $payeeTradePartyElements->item(0);

        $identifierElements = $xpath->query('.//ram:ID', $payeeTradePartyElement);
        $nameElements       = $xpath->query('.//ram:Name', $payeeTradePartyElement);

        if ($identifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        if (1 !== $nameElements->count()) {
            throw new \Exception('Malformed');
        }

        $name = $nameElements->item(0)->nodeValue;

        $globalIdentifier           = PayeeGlobalIdentifier::fromXML($xpath, $payeeTradePartyElement);
        $specifiedLegalOrganization = PayeeSpecifiedLegalOrganization::fromXML($xpath, $payeeTradePartyElement);

        $payeeTradeParty = new self($name);

        if (1 === $identifierElements->count()) {
            $payeeTradeParty->setIdentifier(new PayeeIdentifier($identifierElements->item(0)->nodeValue));
        }

        if ($globalIdentifier instanceof PayeeGlobalIdentifier) {
            $payeeTradeParty->setGlobalIdentifier($globalIdentifier);
        }

        if ($specifiedLegalOrganization instanceof PayeeSpecifiedLegalOrganization) {
            $payeeTradeParty->setSpecifiedLegalOrganization($specifiedLegalOrganization);
        }

        return $payeeTradeParty;
    }

    public static function fromEN16931(Payee $payee): self
    {
        $identifier       = null;
        $globalIdentifier = null;

        if ($payee->getIdentifier()->scheme instanceof InternationalCodeDesignator) {
            $globalIdentifier = new PayeeGlobalIdentifier($payee->getIdentifier()->value, $payee->getIdentifier()->scheme);
        } else {
            $identifier = $payee->getIdentifier();
        }

        return (new self($payee->getName()))
            ->setIdentifier($identifier)
            ->setGlobalIdentifier($globalIdentifier)
            ->setSpecifiedLegalOrganization(
                $payee->getLegalRegistrationIdentifier() instanceof LegalRegistrationIdentifier
                    ? new PayeeSpecifiedLegalOrganization($payee->getLegalRegistrationIdentifier())
                    : null
            );
    }
}
