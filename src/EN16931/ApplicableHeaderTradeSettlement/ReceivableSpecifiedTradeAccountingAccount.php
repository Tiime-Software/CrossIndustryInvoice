<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931\ApplicableHeaderTradeSettlement;

/**
 * BT-19-00.
 */
class ReceivableSpecifiedTradeAccountingAccount
{
    /**
     * BT-19.
     */
    private ?string $id;

    public function __construct()
    {
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
