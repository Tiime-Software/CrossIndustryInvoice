<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\EN16931;

use Tiime\CrossIndustryInvoice\EN16931\SpecifiedLineTradeSettlement\ApplicableTradeTax;

/**
 * BG-30-00.
 */
class SpecifiedLineTradeSettlement
{
    /**
     * BG-30
     */
    private ApplicableTradeTax $applicableTradeTax;

    public function __construct(ApplicableTradeTax $applicableTradeTax)
    {
        $this->applicableTradeTax = $applicableTradeTax;
    }

    public function getApplicableTradeTax(): ApplicableTradeTax
    {
        return $this->applicableTradeTax;
    }
}
