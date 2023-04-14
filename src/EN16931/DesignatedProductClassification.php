<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

/**
 * BT-158-00.
 */
class DesignatedProductClassification
{
    /**
     * BT-158 & BT-158-1 & BT-158-2.
     */
    private ?ClassCode $classCode;

    public function __construct()
    {
    }

    public function getClassCode(): ?ClassCode
    {
        return $this->classCode;
    }

    public function setClassCode(?ClassCode $classCode): void
    {
        $this->classCode = $classCode;
    }
}
