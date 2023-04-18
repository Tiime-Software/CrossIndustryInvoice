<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;

/**
 * BT-30-00.
 */
class SellerSpecifiedLegalOrganization
{
    /**
     * BT-30 & BT-30-1.
     */
    private ?LegalRegistrationIdentifier $identifier;

    public function __construct()
    {
        $this->identifier = null;
    }

    public function getIdentifier(): ?LegalRegistrationIdentifier
    {
        return $this->identifier;
    }

    public function setIdentifier(?LegalRegistrationIdentifier $identifier): void
    {
        $this->identifier = $identifier;
    }
}
