<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

/**
 * BT-43-00 or BT-58-00.
 */
class EmailURIUniversalCommunication
{
    /**
     * BT-43 or BT-58.
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
