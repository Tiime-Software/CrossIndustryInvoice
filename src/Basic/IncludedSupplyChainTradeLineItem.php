<?php

namespace Tiime\CrossIndustryInvoice\Basic;

use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;

class IncludedSupplyChainTradeLineItem
{
    private AssociatedDocumentLineDocument $associatedDocumentLineDocument;
    private SpecifiedTradeProduct $specifiedTradeProduct;
    private SpecifiedLineTradeAgreement $specifiedLineTradeAgreement;
    private SpecifiedLineTradeDelivery $specifiedLineTradeDelivery;
    private SpecifiedLineTradeSettlement $specifiedLineTradeSettlement;
}