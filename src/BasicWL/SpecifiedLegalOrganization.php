<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\Identifier\PayeeIdentifier;

/**
 * BT-61-00.
 */
class SpecifiedLegalOrganization
{
    /**
     * BT-61 & BT-61-1.
     */
    private PayeeIdentifier $id;
}
