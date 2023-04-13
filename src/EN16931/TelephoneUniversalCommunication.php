<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BT-42-00.
 */
class TelephoneUniversalCommunication
{
    /**
     * BT-42 or BT-57.
     */
    private string $completeNumber;

    public function __construct(string $completeNumber)
    {
        $this->completeNumber = $completeNumber;
    }

    public function getCompleteNumber(): string
    {
        return $this->completeNumber;
    }
}
