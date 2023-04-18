<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType\EN16931;

use Tiime\CrossIndustryInvoice\DataType\TaxPointDate;
use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\SemanticDataType\Amount;

/**
 * BG-23.
 */
class HeaderApplicableTradeTax extends \Tiime\CrossIndustryInvoice\DataType\BasicWL\HeaderApplicableTradeTax
{
    /**
     * BT-7-00.
     */
    private ?TaxPointDate $taxPointDate;

    public function __construct(Amount $calculatedAmount, Amount $basisAmount, VatCategory $categoryCode)
    {
        parent::__construct($calculatedAmount, $basisAmount, $categoryCode);
        $this->taxPointDate = null;
    }

    public function getTaxPointDate(): ?TaxPointDate
    {
        return $this->taxPointDate;
    }

    public function setTaxPointDate(?TaxPointDate $taxPointDate): void
    {
        $this->taxPointDate = $taxPointDate;
    }
}
