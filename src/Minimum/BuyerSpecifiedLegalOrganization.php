<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Minimum;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;

/**
 * BT-47-00
 */
class BuyerSpecifiedLegalOrganization
{
    /**
     * BT-47
     */
    private string $id;

    /**
     * BT-47-1
     */
    private ?InternationalCodeDesignator $schemeID;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->schemeID = null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSchemeId(): ?InternationalCodeDesignator
    {
        return $this->schemeId;
    }

    public function setSchemeId(?InternationalCodeDesignator $schemeId): void
    {
        $this->schemeId = $schemeId;
    }
}