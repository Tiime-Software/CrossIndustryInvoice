<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeePartyCreditorFinancialAccount;
use Tiime\EN16931\DataType\PaymentMeansCode;

/**
 * BG-16.
 */
class SpecifiedTradeSettlementPaymentMeans
{
    protected const XML_NODE = 'ram:SpecifiedTradeSettlementPaymentMeans';

    /**
     * BT-81.
     */
    private PaymentMeansCode $typeCode;

    /**
     * BT-91-00.
     */
    private ?PayerPartyDebtorFinancialAccount $payerPartyDebtorFinancialAccount;

    /**
     * BG-17.
     */
    private ?PayeePartyCreditorFinancialAccount $payeePartyCreditorFinancialAccount;

    public function __construct(PaymentMeansCode $typeCode)
    {
        $this->typeCode                           = $typeCode;
        $this->payerPartyDebtorFinancialAccount   = null;
        $this->payeePartyCreditorFinancialAccount = null;
    }

    public function getTypeCode(): PaymentMeansCode
    {
        return $this->typeCode;
    }

    public function getPayerPartyDebtorFinancialAccount(): ?PayerPartyDebtorFinancialAccount
    {
        return $this->payerPartyDebtorFinancialAccount;
    }

    public function setPayerPartyDebtorFinancialAccount(?PayerPartyDebtorFinancialAccount $payerPartyDebtorFinancialAccount): static
    {
        $this->payerPartyDebtorFinancialAccount = $payerPartyDebtorFinancialAccount;

        return $this;
    }

    public function getPayeePartyCreditorFinancialAccount(): ?PayeePartyCreditorFinancialAccount
    {
        return $this->payeePartyCreditorFinancialAccount;
    }

    public function setPayeePartyCreditorFinancialAccount(?PayeePartyCreditorFinancialAccount $payeePartyCreditorFinancialAccount): static
    {
        $this->payeePartyCreditorFinancialAccount = $payeePartyCreditorFinancialAccount;

        return $this;
    }

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement(self::XML_NODE);

        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode->value));

        if ($this->payerPartyDebtorFinancialAccount instanceof PayerPartyDebtorFinancialAccount) {
            $element->appendChild($this->payerPartyDebtorFinancialAccount->toXML($document));
        }

        if ($this->payeePartyCreditorFinancialAccount instanceof PayeePartyCreditorFinancialAccount) {
            $element->appendChild($this->payeePartyCreditorFinancialAccount->toXML($document));
        }

        return $element;
    }

    public static function fromXML(\DOMXPath $xpath, \DOMElement $currentElement): ?self
    {
        $specifiedTradeSettlementPaymentMeansElements = $xpath->query(sprintf('.//%s', self::XML_NODE), $currentElement);

        if (0 === $specifiedTradeSettlementPaymentMeansElements->count()) {
            return null;
        }

        if ($specifiedTradeSettlementPaymentMeansElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $specifiedTradeSettlementPaymentMeansElement */
        $specifiedTradeSettlementPaymentMeansElement = $specifiedTradeSettlementPaymentMeansElements->item(0);

        $typeCodeElements = $xpath->query('.//ram:TypeCode', $specifiedTradeSettlementPaymentMeansElement);

        if (1 !== $typeCodeElements->count()) {
            throw new \Exception('Malformed');
        }

        $typeCode = PaymentMeansCode::tryFrom($typeCodeElements->item(0)->nodeValue);

        if (null === $typeCode) {
            throw new \Exception('Wrong TypeCode');
        }

        $payerPartyDebtorFinancialAccount   = PayerPartyDebtorFinancialAccount::fromXML($xpath, $specifiedTradeSettlementPaymentMeansElement);
        $payeePartyCreditorFinancialAccount = PayeePartyCreditorFinancialAccount::fromXML($xpath, $specifiedTradeSettlementPaymentMeansElement);

        $specifiedTradeSettlementPaymentMeans = new self($typeCode);

        if ($payerPartyDebtorFinancialAccount instanceof PayerPartyDebtorFinancialAccount) {
            $specifiedTradeSettlementPaymentMeans->setPayerPartyDebtorFinancialAccount($payerPartyDebtorFinancialAccount);
        }

        if ($payeePartyCreditorFinancialAccount instanceof PayeePartyCreditorFinancialAccount) {
            $specifiedTradeSettlementPaymentMeans->setPayeePartyCreditorFinancialAccount($payeePartyCreditorFinancialAccount);
        }

        return $specifiedTradeSettlementPaymentMeans;
    }
}
