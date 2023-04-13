<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

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

    /**
     * BT-28.
     */
    private ?string $tradingBusinessName;
}
