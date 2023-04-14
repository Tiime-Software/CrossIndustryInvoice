<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BG-18.
 */
class ApplicableTradeSettlementFinancialCard
{
    /**
     * BT-87.
     */
    private string $id;

    /**
     * BT-88.
     */
    private ?string $cardholderName;

    public function __construct(string $id)
    {
        $this->id             = $id;
        $this->cardholderName = null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCardholderName(): ?string
    {
        return $this->cardholderName;
    }

    public function setCardholderName(?string $cardholderName): void
    {
        $this->cardholderName = $cardholderName;
    }
}
