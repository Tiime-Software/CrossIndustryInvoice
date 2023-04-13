<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BT-43-00.
 */
class EmailURIUniversalCommunication
{
    /**
     * BT-43.
     */
    private string $uriID;

    public function __construct(string $uriID)
    {
        $this->uriID = $uriID;
    }

    public function getUriID(): string
    {
        return $this->uriID;
    }
}
