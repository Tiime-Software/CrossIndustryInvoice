<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\Minimum;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;

/**
 * BT-47-00.
 */
class BuyerSpecifiedLegalOrganization
{
    /**
     * BT-47 & BT-47-1.
     */
    private LegalRegistrationIdentifier $identifier;

    public function __construct(LegalRegistrationIdentifier $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): ?LegalRegistrationIdentifier
    {
        return $this->identifier;
    }
}