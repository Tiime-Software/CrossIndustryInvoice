<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\Identifier\PayeeIdentifier;

/**
 * BG-10.
 */
class PayeeTradeParty
{
    /**
     * BT-60.
     */
    private ?PayeeIdentifier $id;

    /**
     * BT-60-0 & BT-60-1.
     */
    private ?PayeeIdentifier $globalId;

    /**
     * BT-59.
     */
    private string $name;

    /**
     * BT-61-00.
     */
    private ?SpecifiedLegalOrganization $specifiedLegalOrganization;
}
