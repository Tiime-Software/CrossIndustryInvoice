<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\BasicWL;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;

/**
 * BT-47-00.
 */
class BuyerSpecifiedLegalOrganization extends \Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization
{
    public function __construct(LegalRegistrationIdentifier $identifier)
    {
        parent::__construct($identifier);
    }
}
