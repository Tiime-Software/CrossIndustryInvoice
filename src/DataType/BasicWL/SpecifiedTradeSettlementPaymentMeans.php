<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\PayerPartyDebtorFinancialAccount;
use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\Codelist\PaymentMeansCodeUNTDID4461;

/**
 * BG-16.
 */
class SpecifiedTradeSettlementPaymentMeans
{
    protected const string XML_NODE = 'ram:SpecifiedTradeSettlementPaymentMeans';

    /**
     * BT-91-00.
     */
    protected ?PayerPartyDebtorFinancialAccount $payerPartyDebtorFinancialAccount;

    /**
     * BG-17.
     */
    protected ?PayeePartyCreditorFinancialAccount $payeePartyCreditorFinancialAccount;

    /**
     * @param PaymentMeansCodeUNTDID4461 $typeCode - BT-81
     */
    public function __construct(
        protected PaymentMeansCodeUNTDID4461 $typeCode,
    ) {
        $this->payerPartyDebtorFinancialAccount   = null;
        $this->payeePartyCreditorFinancialAccount = null;
    }

    public function getTypeCode(): PaymentMeansCodeUNTDID4461
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
            $payeePartyCreditorFinancialAccountXml = $this->payeePartyCreditorFinancialAccount->toXML($document);

            if ($payeePartyCreditorFinancialAccountXml instanceof \DOMElement) {
                $element->appendChild($payeePartyCreditorFinancialAccountXml);
            }
        }

        return $element;
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): array
    {
        $specifiedTradeSettlementPaymentMeansElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $specifiedTradeSettlementPaymentMeansElements->count()) {
            return [];
        }

        $outputSpecifiedTradeSettlementPaymentMeans = [];

        /** @var \DOMElement $specifiedTradeSettlementPaymentMeansElement */
        foreach ($specifiedTradeSettlementPaymentMeansElements as $specifiedTradeSettlementPaymentMeansElement) {
            $typeCodeElements = $xpath->query('./ram:TypeCode', $specifiedTradeSettlementPaymentMeansElement);

            if (1 !== $typeCodeElements->count()) {
                throw new \Exception('Malformed');
            }

            $typeCode = PaymentMeansCodeUNTDID4461::tryFrom($typeCodeElements->item(0)->nodeValue);

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

            $outputSpecifiedTradeSettlementPaymentMeans[] = $specifiedTradeSettlementPaymentMeans;
        }

        return $outputSpecifiedTradeSettlementPaymentMeans;
    }
}
