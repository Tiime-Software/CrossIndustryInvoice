<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;

/**
 * BT-61-00.
 */
class PayeeSpecifiedLegalOrganization extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeeSpecifiedLegalOrganization
{
    public function __construct(LegalRegistrationIdentifier $identifier)
    {
        parent::__construct($identifier);
    }
}
