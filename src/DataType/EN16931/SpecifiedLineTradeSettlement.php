<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\AdditionalReferencedDocumentInvoiceLineObjectIdentifier;
use Tiime\CrossIndustryInvoice\DataType\Basic\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\DataType\ReceivableSpecifiedTradeAccountingAccount;
use Tiime\EN16931\BusinessTermsGroup\InvoiceLine;
use Tiime\EN16931\BusinessTermsGroup\InvoiceLinePeriod;
use Tiime\EN16931\DataType\Identifier\ObjectIdentifier;

/**
 * BG-30-00.
 */
class SpecifiedLineTradeSettlement extends \Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeSettlement
{
    /**
     * BT-128-00.
     */
    private ?AdditionalReferencedDocumentInvoiceLineObjectIdentifier $additionalReferencedDocument;

    /**
     * BT-133-00.
     */
    private ?ReceivableSpecifiedTradeAccountingAccount $receivableSpecifiedTradeAccountingAccount;

    public function __construct(
        ApplicableTradeTax $applicableTradeTax,
        SpecifiedTradeSettlementLineMonetarySummation $specifiedTradeSettlementLineMonetarySummation
    ) {
        parent::__construct($applicableTradeTax, $specifiedTradeSettlementLineMonetarySummation);

        $this->additionalReferencedDocument              = null;
        $this->receivableSpecifiedTradeAccountingAccount = null;
    }

    public function setSpecifiedTradeAllowances(array $specifiedTradeAllowances): static
    {
        $tmpSpecifiedTradeAllowances = [];

        foreach ($specifiedTradeAllowances as $specifiedTradeAllowance) {
            if (!$specifiedTradeAllowance instanceof LineSpecifiedTradeAllowance) {
                throw new \TypeError();
            }
            $tmpSpecifiedTradeAllowances[] = $specifiedTradeAllowance;
        }

        $this->specifiedTradeAllowances = $tmpSpecifiedTradeAllowances;

        return $this;
    }

    public function setSpecifiedTradeCharges(array $specifiedTradeCharges): static
    {
        $tmpSpecifiedTradeCharges = [];

        foreach ($specifiedTradeCharges as $specifiedTradeCharge) {
            if (!$specifiedTradeCharge instanceof LineSpecifiedTradeCharge) {
                throw new \TypeError();
            }
            $tmpSpecifiedTradeCharges[] = $specifiedTradeCharge;
        }

        $this->specifiedTradeCharges = $tmpSpecifiedTradeCharges;

        return $this;
    }

    public function getAdditionalReferencedDocument(): ?AdditionalReferencedDocumentInvoiceLineObjectIdentifier
    {
        return $this->additionalReferencedDocument;
    }

    public function setAdditionalReferencedDocument(?AdditionalReferencedDocumentInvoiceLineObjectIdentifier $additionalReferencedDocument): static
    {
        $this->additionalReferencedDocument = $additionalReferencedDocument;

        return $this;
    }

    public function getReceivableSpecifiedTradeAccountingAccount(): ?ReceivableSpecifiedTradeAccountingAccount
    {
        return $this->receivableSpecifiedTradeAccountingAccount;
    }

    public function setReceivableSpecifiedTradeAccountingAccount(?ReceivableSpecifiedTradeAccountingAccount $receivableSpecifiedTradeAccountingAccount): static
    {
        $this->receivableSpecifiedTradeAccountingAccount = $receivableSpecifiedTradeAccountingAccount;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $currentNode = $document->createElement(self::XML_NODE);

        $currentNode->appendChild($this->applicableTradeTax->toXML($document));

        if ($this->billingSpecifiedPeriod instanceof BillingSpecifiedPeriod) {
            $currentNode->appendChild($this->billingSpecifiedPeriod->toXML($document));
        }

        foreach ($this->specifiedTradeAllowances as $specifiedTradeAllowance) {
            $currentNode->appendChild($specifiedTradeAllowance->toXML($document));
        }

        foreach ($this->specifiedTradeCharges as $specifiedTradeCharge) {
            $currentNode->appendChild($specifiedTradeCharge->toXML($document));
        }

        $currentNode->appendChild($this->specifiedTradeSettlementLineMonetarySummation->toXML($document));

        if ($this->additionalReferencedDocument instanceof AdditionalReferencedDocumentInvoiceLineObjectIdentifier) {
            $currentNode->appendChild($this->additionalReferencedDocument->toXML($document));
        }

        if ($this->receivableSpecifiedTradeAccountingAccount instanceof ReceivableSpecifiedTradeAccountingAccount) {
            $currentNode->appendChild($this->receivableSpecifiedTradeAccountingAccount->toXML($document));
        }

        return $currentNode;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): self
    {
        $specifiedLineTradeSettlementElements = $xpath->query(sprintf('./%s', self::XML_NODE), $currentElement);

        if (1 !== $specifiedLineTradeSettlementElements->count()) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedLineTradeSettlementElement */
        $specifiedLineTradeSettlementElement = $specifiedLineTradeSettlementElements->item(0);

        $applicableTradeTax                            = ApplicableTradeTax::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $billingSpecifiedPeriod                        = BillingSpecifiedPeriod::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $specifiedTradeAllowances                      = LineSpecifiedTradeAllowance::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $specifiedTradeCharges                         = LineSpecifiedTradeCharge::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $specifiedTradeSettlementLineMonetarySummation = SpecifiedTradeSettlementLineMonetarySummation::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $additionalReferencedDocument                  = AdditionalReferencedDocumentInvoiceLineObjectIdentifier::fromXML($xpath, $specifiedLineTradeSettlementElement);
        $receivableSpecifiedTradeAccountingAccount     = ReceivableSpecifiedTradeAccountingAccount::fromXML($xpath, $specifiedLineTradeSettlementElement);

        $specifiedLineTradeSettlement = new self($applicableTradeTax, $specifiedTradeSettlementLineMonetarySummation);

        if ($billingSpecifiedPeriod instanceof BillingSpecifiedPeriod) {
            $specifiedLineTradeSettlement->setBillingSpecifiedPeriod($billingSpecifiedPeriod);
        }

        if (\count($specifiedTradeAllowances) > 0) {
            $specifiedLineTradeSettlement->setSpecifiedTradeAllowances($specifiedTradeAllowances);
        }

        if (\count($specifiedTradeCharges) > 0) {
            $specifiedLineTradeSettlement->setSpecifiedTradeCharges($specifiedTradeCharges);
        }

        if ($additionalReferencedDocument instanceof AdditionalReferencedDocumentInvoiceLineObjectIdentifier) {
            $specifiedLineTradeSettlement->setAdditionalReferencedDocument($additionalReferencedDocument);
        }

        if ($receivableSpecifiedTradeAccountingAccount instanceof ReceivableSpecifiedTradeAccountingAccount) {
            $specifiedLineTradeSettlement->setReceivableSpecifiedTradeAccountingAccount($receivableSpecifiedTradeAccountingAccount);
        }

        return $specifiedLineTradeSettlement;
    }

    public static function fromEN16931(InvoiceLine $invoiceLine): self
    {
        $applicableTradeTax = (new ApplicableTradeTax($invoiceLine->getLineVatInformation()->getInvoicedItemVatCategoryCode()))
            ->setRateApplicablePercent($invoiceLine->getLineVatInformation()->getInvoicedItemVatRate()?->getValueRounded());

        $specifiedTradeAllowances = [];
        $specifiedTradeCharges    = [];

        foreach ($invoiceLine->getAllowances() as $allowance) {
            $specifiedTradeAllowances[] = LineSpecifiedTradeAllowance::fromEN16931($allowance);
        }

        foreach ($invoiceLine->getCharges() as $charge) {
            $specifiedTradeCharges[] = LineSpecifiedTradeCharge::fromEN16931($charge);
        }

        $specifiedLineTradeSettlement = new self(
            $applicableTradeTax,
            new SpecifiedTradeSettlementLineMonetarySummation($invoiceLine->getNetAmount()->getValueRounded())
        );

        $specifiedLineTradeSettlement
            ->setBillingSpecifiedPeriod(
                $invoiceLine->getPeriod() instanceof InvoiceLinePeriod
                    ? BillingSpecifiedPeriod::fromEN16931($invoiceLine->getPeriod())
                    : null
            )
            ->setSpecifiedTradeAllowances($specifiedTradeAllowances)
            ->setSpecifiedTradeCharges($specifiedTradeCharges)
            ->setAdditionalReferencedDocument(
                $invoiceLine->getObjectIdentifier() instanceof ObjectIdentifier
                    ? new AdditionalReferencedDocumentInvoiceLineObjectIdentifier($invoiceLine->getObjectIdentifier())
                    : null
            )
            ->setReceivableSpecifiedTradeAccountingAccount(
                \is_string($invoiceLine->getBuyerAccountingReference())
                    ? new ReceivableSpecifiedTradeAccountingAccount($invoiceLine->getBuyerAccountingReference())
                    : null
            );

        return $specifiedLineTradeSettlement;
    }
}
