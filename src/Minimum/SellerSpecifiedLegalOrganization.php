<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-30-00.
 */
class SellerSpecifiedLegalOrganization
{
    /**
     * BT-30.
     */
    private string $id;

    /**
     * BT-30-1.
     */
    private ?InternationalCodeDesignator $schemeID;

    public function __construct(string $id)
    {
        $this->id       = $id;
        $this->schemeID = null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSchemeId(): ?InternationalCodeDesignator
    {
        return $this->schemeID;
    }

    public function setSchemeId(?InternationalCodeDesignator $schemeId): void
    {
        $this->schemeID = $schemeId;
    }
}
