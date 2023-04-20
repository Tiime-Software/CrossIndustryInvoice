<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeePartyCreditorFinancialAccount;
use Tiime\CrossIndustryInvoice\DataType\PayerPartyDebtorFinancialAccount;
use Tiime\EN16931\DataType\PaymentMeansCode;

/**
 * BG-16.
 */
class SpecifiedTradeSettlementPaymentMeans
{
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

    public function toXML(\DOMDocument $document): \DOMElement
    {
        $element = $document->createElement('ram:SpecifiedTradeSettlementPaymentMeans');

        $element->appendChild($document->createElement('ram:TypeCode', $this->typeCode->value));

        if ($this->payerPartyDebtorFinancialAccount instanceof PayerPartyDebtorFinancialAccount) {
            $element->appendChild($this->payerPartyDebtorFinancialAccount->toXML($document));
        }

        if ($this->payeePartyCreditorFinancialAccount instanceof PayeePartyCreditorFinancialAccount) {
            $element->appendChild($this->payeePartyCreditorFinancialAccount->toXML($document));
        }

        return $element;
    }
}
