<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BG-32.
 */
class ApplicableProductCharacteristic
{
    /**
     * BT-160.
     */
    private string $description;

    /**
     * BT-161.
     */
    private string $value;

    public function __construct(string $description, string $value)
    {
        $this->description = $description;
        $this->value       = $value;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
