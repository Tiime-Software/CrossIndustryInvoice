<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\EN16931\DataType\Identifier\PaymentServiceProviderIdentifier;

class PayeeSpecifiedCreditorFinancialInstitution
{
    /**
     * BT-86.
     */
    private PaymentServiceProviderIdentifier $bicID;

    public function __construct(PaymentServiceProviderIdentifier $bicID)
    {
        $this->bicID = $bicID;
    }

    public function getBicID(): PaymentServiceProviderIdentifier
    {
        return $this->bicID;
    }
}
