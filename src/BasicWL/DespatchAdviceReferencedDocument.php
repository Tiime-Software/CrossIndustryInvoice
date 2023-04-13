<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\BasicWL;

use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;

/**
 * BT-16-00.
 */
class DespatchAdviceReferencedDocument
{
    /**
     * BT-16.
     */
    private DespatchAdviceReference $issuerAssignedId;
}
