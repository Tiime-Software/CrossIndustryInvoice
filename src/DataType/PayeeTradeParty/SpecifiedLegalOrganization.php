<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty;

use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;

/**
 * BT-61-00.
 */
class SpecifiedLegalOrganization
{
    /**
     * BT-61.
     */
    private LegalRegistrationIdentifier $legalRegistrationIdentifier;

    public function __construct(LegalRegistrationIdentifier $legalRegistrationIdentifier)
    {
        $this->legalRegistrationIdentifier = $legalRegistrationIdentifier;
    }

    public function getLegalRegistrationIdentifier(): LegalRegistrationIdentifier
    {
        return $this->legalRegistrationIdentifier;
    }
}
