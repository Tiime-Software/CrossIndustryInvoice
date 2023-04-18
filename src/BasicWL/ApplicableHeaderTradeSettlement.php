<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\DataType\ReceivableSpecifiedTradeAccountingAccount;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\Identifier\BankAssignedCreditorIdentifier;

/**
 * BG-19.
 */
class ApplicableHeaderTradeSettlement
{
    /**
     * BT-90.
     */
    private ?BankAssignedCreditorIdentifier $creditorReferenceId;

    /**
     * BT-83.
     */
    private ?string $paymentReference;

    /**
     * BT-6.
     */
    private ?CurrencyCode $taxCurrencyCode;

    /**
     * BT-5.
     */
    private CurrencyCode $invoiceCurrencyCode;

    /**
     * BG-10.
     */
    private ?PayeeTradeParty $payeeTradeParty;

    /**
     * BG-16.
     */
    private ?SpecifiedTradeSettlementPaymentMeans $specifiedTradeSettlementPaymentMeans;

    /**
     * BG-23.
     *
     * @var non-empty-array<int, ApplicableTradeTax>
     */
    private array $applicableTradeTaxes;

    /**
     * BG-14.
     */
    private ?BillingSpecifiedPeriod $billingSpecifiedPeriod;

    /**
     * BG-20.
     *
     * @var array<int, SpecifiedTradeAllowance>
     */
    private array $specifiedTradeAllowances;

    /**
     * BG-21.
     *
     * @var array<int, SpecifiedTradeCharge>
     */
    private array $specifiedTradeCharges;

    /**
     * BT-20-00.
     */
    private ?SpecifiedTradePaymentTerms $specifiedTradePaymentTerms;

    /**
     * BG-22.
     */
    private SpecifiedTradeSettlementHeaderMonetarySummation $specifiedTradeSettlementHeaderMonetarySummation;

    /**
     * BG-3.
     */
    private ?InvoiceReferencedDocument $invoiceReferencedDocument;

    /**
     * BT-19-00.
     */
    private ?ReceivableSpecifiedTradeAccountingAccount $receivableSpecifiedTradeAccountingAccount;
}
