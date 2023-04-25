<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeProduct;

class IncludedSupplyChainTradeLineItem
{
    private AssociatedDocumentLineDocument $associatedDocumentLineDocument;
    private SpecifiedTradeProduct $specifiedTradeProduct;
    private SpecifiedLineTradeAgreement $specifiedLineTradeAgreement;
    private SpecifiedLineTradeDelivery $specifiedLineTradeDelivery;
    private SpecifiedLineTradeSettlement $specifiedLineTradeSettlement;
}
