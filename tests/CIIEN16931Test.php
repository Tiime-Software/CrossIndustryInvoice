<?php

namespace Tiime\CrossIndustryInvoice\Tests;

use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\DataType\ActualDeliverySupplyChainEvent;
use Tiime\CrossIndustryInvoice\DataType\AdditionalReferencedDocumentInvoiceLineObjectIdentifier;
use Tiime\CrossIndustryInvoice\DataType\ApplicableTradeSettlementFinancialCard;
use Tiime\CrossIndustryInvoice\DataType\AssociatedDocumentLineDocument;
use Tiime\CrossIndustryInvoice\DataType\Basic\ApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\Basic\AppliedTradeAllowanceCharge;
use Tiime\CrossIndustryInvoice\DataType\Basic\BasisQuantity;
use Tiime\CrossIndustryInvoice\DataType\Basic\BilledQuantity;
use Tiime\CrossIndustryInvoice\DataType\Basic\GrossPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedLineTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\Basic\SpecifiedTradeSettlementLineMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\PayeeSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\BillingSpecifiedPeriod;
use Tiime\CrossIndustryInvoice\DataType\BusinessProcessSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\BuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\CategoryTradeTax;
use Tiime\CrossIndustryInvoice\DataType\ContractReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\DefinedTradeContact;
use Tiime\CrossIndustryInvoice\DataType\DespatchAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\DocumentIncludedNote;
use Tiime\CrossIndustryInvoice\DataType\DueDateDateTime;
use Tiime\CrossIndustryInvoice\DataType\EmailURIUniversalCommunication;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\EN16931\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\BuyerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\EN16931\BuyerTradeParty;
use Tiime\CrossIndustryInvoice\DataType\EN16931\HeaderApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\EN16931\IncludedSupplyChainTradeLineItem;
use Tiime\CrossIndustryInvoice\DataType\EN16931\LineSpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\EN16931\LineSpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\EN16931\PayeePartyCreditorFinancialAccount;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SellerTradeParty;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedLineTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedLineTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeProduct;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeSettlementPaymentMeans;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SupplyChainTradeTransaction;
use Tiime\CrossIndustryInvoice\DataType\EndDateTime;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;
use Tiime\CrossIndustryInvoice\DataType\FormattedIssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\GuidelineSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\InvoiceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\LineBuyerOrderReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\LocationGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\NetPriceProductTradePrice;
use Tiime\CrossIndustryInvoice\DataType\OccurrenceDateTime;
use Tiime\CrossIndustryInvoice\DataType\PayeeGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\PayeeSpecifiedCreditorFinancialInstitution;
use Tiime\CrossIndustryInvoice\DataType\PayeeTradeParty;
use Tiime\CrossIndustryInvoice\DataType\PayerPartyDebtorFinancialAccount;
use Tiime\CrossIndustryInvoice\DataType\ReceivableSpecifiedTradeAccountingAccount;
use Tiime\CrossIndustryInvoice\DataType\ReceivingAdviceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\ShipToTradeParty;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationVA;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradePaymentTerms;
use Tiime\CrossIndustryInvoice\DataType\StartDateTime;
use Tiime\CrossIndustryInvoice\DataType\TaxPointDate;
use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\CrossIndustryInvoice\DataType\TelephoneUniversalCommunication;
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\Utils\CrossIndustryInvoiceUtils;
use Tiime\EN16931\DataType\AllowanceReasonCode;
use Tiime\EN16931\DataType\ChargeReasonCode;
use Tiime\EN16931\DataType\CountryAlpha2Code;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\DateCode2005;
use Tiime\EN16931\DataType\DateCode2475;
use Tiime\EN16931\DataType\Identifier\BankAssignedCreditorIdentifier;
use Tiime\EN16931\DataType\Identifier\DebitedAccountIdentifier;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\Identifier\InvoiceLineIdentifier;
use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\LocationIdentifier;
use Tiime\EN16931\DataType\Identifier\MandateReferenceIdentifier;
use Tiime\EN16931\DataType\Identifier\ObjectIdentifier;
use Tiime\EN16931\DataType\Identifier\PayeeIdentifier;
use Tiime\EN16931\DataType\Identifier\PaymentAccountIdentifier;
use Tiime\EN16931\DataType\Identifier\PaymentServiceProviderIdentifier;
use Tiime\EN16931\DataType\Identifier\SellerItemIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\Identifier\StandardItemIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;
use Tiime\EN16931\DataType\InvoiceNoteCode;
use Tiime\EN16931\DataType\InvoiceTypeCode;
use Tiime\EN16931\DataType\ObjectSchemeCode;
use Tiime\EN16931\DataType\PaymentMeansCode;
use Tiime\EN16931\DataType\Reference\ContractReference;
use Tiime\EN16931\DataType\Reference\DespatchAdviceReference;
use Tiime\EN16931\DataType\Reference\PrecedingInvoiceReference;
use Tiime\EN16931\DataType\Reference\PurchaseOrderLineReference;
use Tiime\EN16931\DataType\Reference\PurchaseOrderReference;
use Tiime\EN16931\DataType\Reference\ReceivingAdviceReference;
use Tiime\EN16931\DataType\UnitOfMeasurement;
use Tiime\EN16931\DataType\VatCategory;
use Tiime\EN16931\DataType\VatExoneration;
use Tiime\EN16931\SemanticDataType\Percentage;

class CIIEN16931Test extends TestCase
{
    public function testCheckXsdWithRemovedGuidelineSpecifiedDocumentContextParameter(): void
    {
        $xmlEn16931 = "<?xml version='1.0' encoding='UTF-8'?>
            <rsm:CrossIndustryInvoice xmlns:qdt=\"urn:un:unece:uncefact:data:standard:QualifiedDataType:100\" xmlns:ram=\"urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100\" xmlns:rsm=\"urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100\" xmlns:udt=\"urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
              <rsm:ExchangedDocumentContext>
              </rsm:ExchangedDocumentContext>
              <rsm:ExchangedDocument>
                <ram:ID>FA-2017-0010</ram:ID>
                <ram:TypeCode>380</ram:TypeCode>
                <ram:IssueDateTime>
                  <udt:DateTimeString format=\"102\">20171113</udt:DateTimeString>
                </ram:IssueDateTime>
                <ram:IncludedNote>
                  <ram:Content>Franco de port (commande &gt; 300 € HT)</ram:Content>
                </ram:IncludedNote>
              </rsm:ExchangedDocument>
              <rsm:SupplyChainTradeTransaction>
                <ram:IncludedSupplyChainTradeLineItem>
                  <ram:AssociatedDocumentLineDocument>
                    <ram:LineID>1</ram:LineID>
                  </ram:AssociatedDocumentLineDocument>
                  <ram:SpecifiedTradeProduct>
                    <ram:GlobalID schemeID=\"0160\">3518370400049</ram:GlobalID>
                    <ram:SellerAssignedID>NOUG250</ram:SellerAssignedID>
                    <ram:Name>Nougat de l'Abbaye 250g</ram:Name>
                  </ram:SpecifiedTradeProduct>
                  <ram:SpecifiedLineTradeAgreement>
                    <ram:GrossPriceProductTradePrice>
                      <ram:ChargeAmount>4.55</ram:ChargeAmount>
                      <ram:AppliedTradeAllowanceCharge>
                        <ram:ChargeIndicator>
                          <udt:Indicator>false</udt:Indicator>
                        </ram:ChargeIndicator>
                        <ram:ActualAmount>0.45</ram:ActualAmount>
                      </ram:AppliedTradeAllowanceCharge>
                    </ram:GrossPriceProductTradePrice>
                    <ram:NetPriceProductTradePrice>
                      <ram:ChargeAmount>4.10</ram:ChargeAmount>
                    </ram:NetPriceProductTradePrice>
                  </ram:SpecifiedLineTradeAgreement>
                  <ram:SpecifiedLineTradeDelivery>
                    <ram:BilledQuantity unitCode=\"C62\">20.000</ram:BilledQuantity>
                  </ram:SpecifiedLineTradeDelivery>
                  <ram:SpecifiedLineTradeSettlement>
                    <ram:ApplicableTradeTax>
                      <ram:TypeCode>VAT</ram:TypeCode>
                      <ram:CategoryCode>S</ram:CategoryCode>
                      <ram:RateApplicablePercent>20.00</ram:RateApplicablePercent>
                    </ram:ApplicableTradeTax>
                    <ram:SpecifiedTradeSettlementLineMonetarySummation>
                      <ram:LineTotalAmount>81.90</ram:LineTotalAmount>
                    </ram:SpecifiedTradeSettlementLineMonetarySummation>
                  </ram:SpecifiedLineTradeSettlement>
                </ram:IncludedSupplyChainTradeLineItem>
                <ram:IncludedSupplyChainTradeLineItem>
                  <ram:AssociatedDocumentLineDocument>
                    <ram:LineID>2</ram:LineID>
                  </ram:AssociatedDocumentLineDocument>
                  <ram:SpecifiedTradeProduct>
                    <ram:GlobalID schemeID=\"0160\">3518370200090</ram:GlobalID>
                    <ram:SellerAssignedID>BRAIS300</ram:SellerAssignedID>
                    <ram:Name>Biscuits aux raisins 300g</ram:Name>
                  </ram:SpecifiedTradeProduct>
                  <ram:SpecifiedLineTradeAgreement>
                    <ram:GrossPriceProductTradePrice>
                      <ram:ChargeAmount>3.20</ram:ChargeAmount>
                    </ram:GrossPriceProductTradePrice>
                    <ram:NetPriceProductTradePrice>
                      <ram:ChargeAmount>3.20</ram:ChargeAmount>
                    </ram:NetPriceProductTradePrice>
                  </ram:SpecifiedLineTradeAgreement>
                  <ram:SpecifiedLineTradeDelivery>
                    <ram:BilledQuantity unitCode=\"C62\">15.000</ram:BilledQuantity>
                  </ram:SpecifiedLineTradeDelivery>
                  <ram:SpecifiedLineTradeSettlement>
                    <ram:ApplicableTradeTax>
                      <ram:TypeCode>VAT</ram:TypeCode>
                      <ram:CategoryCode>S</ram:CategoryCode>
                      <ram:RateApplicablePercent>5.50</ram:RateApplicablePercent>
                    </ram:ApplicableTradeTax>
                    <ram:SpecifiedTradeSettlementLineMonetarySummation>
                      <ram:LineTotalAmount>48.00</ram:LineTotalAmount>
                    </ram:SpecifiedTradeSettlementLineMonetarySummation>
                  </ram:SpecifiedLineTradeSettlement>
                </ram:IncludedSupplyChainTradeLineItem>
                <ram:IncludedSupplyChainTradeLineItem>
                  <ram:AssociatedDocumentLineDocument>
                    <ram:LineID>3</ram:LineID>
                  </ram:AssociatedDocumentLineDocument>
                  <ram:SpecifiedTradeProduct>
                    <ram:SellerAssignedID>HOLANCL</ram:SellerAssignedID>
                    <ram:Name>Huile d'olive à l'ancienne</ram:Name>
                  </ram:SpecifiedTradeProduct>
                  <ram:SpecifiedLineTradeAgreement>
                    <ram:GrossPriceProductTradePrice>
                      <ram:ChargeAmount>19.80</ram:ChargeAmount>
                    </ram:GrossPriceProductTradePrice>
                    <ram:NetPriceProductTradePrice>
                      <ram:ChargeAmount>19.80</ram:ChargeAmount>
                    </ram:NetPriceProductTradePrice>
                  </ram:SpecifiedLineTradeAgreement>
                  <ram:SpecifiedLineTradeDelivery>
                    <ram:BilledQuantity unitCode=\"LTR\">25.000</ram:BilledQuantity>
                  </ram:SpecifiedLineTradeDelivery>
                  <ram:SpecifiedLineTradeSettlement>
                    <ram:ApplicableTradeTax>
                      <ram:TypeCode>VAT</ram:TypeCode>
                      <ram:CategoryCode>S</ram:CategoryCode>
                      <ram:RateApplicablePercent>5.50</ram:RateApplicablePercent>
                    </ram:ApplicableTradeTax>
                    <ram:SpecifiedTradeSettlementLineMonetarySummation>
                      <ram:LineTotalAmount>495.00</ram:LineTotalAmount>
                    </ram:SpecifiedTradeSettlementLineMonetarySummation>
                  </ram:SpecifiedLineTradeSettlement>
                </ram:IncludedSupplyChainTradeLineItem>
                <ram:ApplicableHeaderTradeAgreement>
                  <ram:SellerTradeParty>
                    <ram:Name>Au bon moulin</ram:Name>
                    <ram:SpecifiedLegalOrganization>
                      <ram:ID schemeID=\"0002\">99999999800010</ram:ID>
                    </ram:SpecifiedLegalOrganization>
                    <ram:DefinedTradeContact>
                      <ram:PersonName>Tony Dubois</ram:PersonName>
                      <ram:TelephoneUniversalCommunication>
                        <ram:CompleteNumber>+33 4 72 07 08 56</ram:CompleteNumber>
                      </ram:TelephoneUniversalCommunication>
                      <ram:EmailURIUniversalCommunication>
                        <ram:URIID schemeID=\"SMTP\">tony.dubois@aubonmoulin.fr</ram:URIID>
                      </ram:EmailURIUniversalCommunication>
                    </ram:DefinedTradeContact>
                    <ram:PostalTradeAddress>
                      <ram:PostcodeCode>84340</ram:PostcodeCode>
                      <ram:LineOne>1242 chemin de l'olive</ram:LineOne>
                      <ram:CityName>Malaucène</ram:CityName>
                      <ram:CountryID>FR</ram:CountryID>
                    </ram:PostalTradeAddress>
                    <ram:SpecifiedTaxRegistration>
                      <ram:ID schemeID=\"VA\">FR11999999998</ram:ID>
                    </ram:SpecifiedTaxRegistration>
                  </ram:SellerTradeParty>
                  <ram:BuyerTradeParty>
                    <ram:Name>Ma jolie boutique</ram:Name>
                    <ram:SpecifiedLegalOrganization>
                      <ram:ID schemeID=\"0002\">78787878400035</ram:ID>
                    </ram:SpecifiedLegalOrganization>
                    <ram:DefinedTradeContact>
                      <ram:PersonName>Alexandre Payet</ram:PersonName>
                      <ram:TelephoneUniversalCommunication>
                        <ram:CompleteNumber>+33 4 72 07 08 67</ram:CompleteNumber>
                      </ram:TelephoneUniversalCommunication>
                      <ram:EmailURIUniversalCommunication>
                        <ram:URIID schemeID=\"SMTP\">alexandre.payet@majolieboutique.net</ram:URIID>
                      </ram:EmailURIUniversalCommunication>
                    </ram:DefinedTradeContact>
                    <ram:PostalTradeAddress>
                      <ram:PostcodeCode>69001</ram:PostcodeCode>
                      <ram:LineOne>35 rue de la République</ram:LineOne>
                      <ram:CityName>Lyon</ram:CityName>
                      <ram:CountryID>FR</ram:CountryID>
                    </ram:PostalTradeAddress>
                    <ram:SpecifiedTaxRegistration>
                      <ram:ID schemeID=\"VA\">FR19787878784</ram:ID>
                    </ram:SpecifiedTaxRegistration>
                  </ram:BuyerTradeParty>
                  <ram:BuyerOrderReferencedDocument>
                    <ram:IssuerAssignedID>PO445</ram:IssuerAssignedID>
                  </ram:BuyerOrderReferencedDocument>
                  <ram:ContractReferencedDocument>
                    <ram:IssuerAssignedID>MSPE2017</ram:IssuerAssignedID>
                  </ram:ContractReferencedDocument>
                </ram:ApplicableHeaderTradeAgreement>
                <ram:ApplicableHeaderTradeDelivery>
                  <ram:ShipToTradeParty>
                    <ram:PostalTradeAddress>
                      <ram:PostcodeCode>69001</ram:PostcodeCode>
                      <ram:LineOne>35 rue de la République</ram:LineOne>
                      <ram:CityName>Lyon</ram:CityName>
                      <ram:CountryID>FR</ram:CountryID>
                    </ram:PostalTradeAddress>
                  </ram:ShipToTradeParty>
                </ram:ApplicableHeaderTradeDelivery>
                <ram:ApplicableHeaderTradeSettlement>
                  <ram:PaymentReference>FA-2017-0010</ram:PaymentReference>
                  <ram:InvoiceCurrencyCode>EUR</ram:InvoiceCurrencyCode>
                  <ram:SpecifiedTradeSettlementPaymentMeans>
                    <ram:TypeCode>30</ram:TypeCode>
                    <ram:Information>Virement sur compte Banque Fiducial</ram:Information>
                    <ram:PayeePartyCreditorFinancialAccount>
                      <ram:IBANID>FR2012421242124212421242124</ram:IBANID>
                    </ram:PayeePartyCreditorFinancialAccount>
                    <ram:PayeeSpecifiedCreditorFinancialInstitution>
                      <ram:BICID>FIDCFR21XXX</ram:BICID>
                    </ram:PayeeSpecifiedCreditorFinancialInstitution>
                  </ram:SpecifiedTradeSettlementPaymentMeans>
                  <ram:ApplicableTradeTax>
                    <ram:CalculatedAmount>16.38</ram:CalculatedAmount>
                    <ram:TypeCode>VAT</ram:TypeCode>
                    <ram:BasisAmount>81.90</ram:BasisAmount>
                    <ram:CategoryCode>S</ram:CategoryCode>
                    <ram:DueDateTypeCode>5</ram:DueDateTypeCode>
                    <ram:RateApplicablePercent>20.00</ram:RateApplicablePercent>
                  </ram:ApplicableTradeTax>
                  <ram:ApplicableTradeTax>
                    <ram:CalculatedAmount>29.87</ram:CalculatedAmount>
                    <ram:TypeCode>VAT</ram:TypeCode>
                    <ram:BasisAmount>543.00</ram:BasisAmount>
                    <ram:CategoryCode>S</ram:CategoryCode>
                    <ram:DueDateTypeCode>5</ram:DueDateTypeCode>
                    <ram:RateApplicablePercent>5.50</ram:RateApplicablePercent>
                  </ram:ApplicableTradeTax>
                  <ram:SpecifiedTradePaymentTerms>
                    <ram:Description>30% d'acompte, solde à 30 j</ram:Description>
                    <ram:DueDateDateTime>
                      <udt:DateTimeString format=\"102\">20171213</udt:DateTimeString>
                    </ram:DueDateDateTime>
                  </ram:SpecifiedTradePaymentTerms>
                  <ram:SpecifiedTradeSettlementHeaderMonetarySummation>
                    <ram:LineTotalAmount>624.90</ram:LineTotalAmount>
                    <ram:TaxBasisTotalAmount>624.90</ram:TaxBasisTotalAmount>
                    <ram:TaxTotalAmount currencyID=\"EUR\">46.25</ram:TaxTotalAmount>
                    <ram:GrandTotalAmount>671.15</ram:GrandTotalAmount>
                    <ram:TotalPrepaidAmount>201.00</ram:TotalPrepaidAmount>
                    <ram:DuePayableAmount>470.15</ram:DuePayableAmount>
                  </ram:SpecifiedTradeSettlementHeaderMonetarySummation>
                </ram:ApplicableHeaderTradeSettlement>
              </rsm:SupplyChainTradeTransaction>
            </rsm:CrossIndustryInvoice>";

        $document = new \DOMDocument();
        $document->loadXML($xmlEn16931);

        $xsdFeedbacks = CrossIndustryInvoiceUtils::validateXSD($document, 'EN16931');

        $this->assertCount(1, $xsdFeedbacks);
    }

    public function testCheckXsd(): void
    {
        $xmlEn16931 = "<?xml version='1.0' encoding='UTF-8'?>
            <rsm:CrossIndustryInvoice xmlns:qdt=\"urn:un:unece:uncefact:data:standard:QualifiedDataType:100\" xmlns:ram=\"urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100\" xmlns:rsm=\"urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100\" xmlns:udt=\"urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
              <rsm:ExchangedDocumentContext>
                <ram:GuidelineSpecifiedDocumentContextParameter>
                  <ram:ID>urn:cen.eu:en16931:2017</ram:ID>
                </ram:GuidelineSpecifiedDocumentContextParameter>
              </rsm:ExchangedDocumentContext>
              <rsm:ExchangedDocument>
                <ram:ID>FA-2017-0010</ram:ID>
                <ram:TypeCode>380</ram:TypeCode>
                <ram:IssueDateTime>
                  <udt:DateTimeString format=\"102\">20171113</udt:DateTimeString>
                </ram:IssueDateTime>
                <ram:IncludedNote>
                  <ram:Content>Franco de port (commande &gt; 300 € HT)</ram:Content>
                </ram:IncludedNote>
              </rsm:ExchangedDocument>
              <rsm:SupplyChainTradeTransaction>
                <ram:IncludedSupplyChainTradeLineItem>
                  <ram:AssociatedDocumentLineDocument>
                    <ram:LineID>1</ram:LineID>
                  </ram:AssociatedDocumentLineDocument>
                  <ram:SpecifiedTradeProduct>
                    <ram:GlobalID schemeID=\"0160\">3518370400049</ram:GlobalID>
                    <ram:SellerAssignedID>NOUG250</ram:SellerAssignedID>
                    <ram:Name>Nougat de l'Abbaye 250g</ram:Name>
                  </ram:SpecifiedTradeProduct>
                  <ram:SpecifiedLineTradeAgreement>
                    <ram:GrossPriceProductTradePrice>
                      <ram:ChargeAmount>4.55</ram:ChargeAmount>
                      <ram:AppliedTradeAllowanceCharge>
                        <ram:ChargeIndicator>
                          <udt:Indicator>false</udt:Indicator>
                        </ram:ChargeIndicator>
                        <ram:ActualAmount>0.45</ram:ActualAmount>
                      </ram:AppliedTradeAllowanceCharge>
                    </ram:GrossPriceProductTradePrice>
                    <ram:NetPriceProductTradePrice>
                      <ram:ChargeAmount>4.10</ram:ChargeAmount>
                    </ram:NetPriceProductTradePrice>
                  </ram:SpecifiedLineTradeAgreement>
                  <ram:SpecifiedLineTradeDelivery>
                    <ram:BilledQuantity unitCode=\"C62\">20.000</ram:BilledQuantity>
                  </ram:SpecifiedLineTradeDelivery>
                  <ram:SpecifiedLineTradeSettlement>
                    <ram:ApplicableTradeTax>
                      <ram:TypeCode>VAT</ram:TypeCode>
                      <ram:CategoryCode>S</ram:CategoryCode>
                      <ram:RateApplicablePercent>20.00</ram:RateApplicablePercent>
                    </ram:ApplicableTradeTax>
                    <ram:SpecifiedTradeSettlementLineMonetarySummation>
                      <ram:LineTotalAmount>81.90</ram:LineTotalAmount>
                    </ram:SpecifiedTradeSettlementLineMonetarySummation>
                  </ram:SpecifiedLineTradeSettlement>
                </ram:IncludedSupplyChainTradeLineItem>
                <ram:IncludedSupplyChainTradeLineItem>
                  <ram:AssociatedDocumentLineDocument>
                    <ram:LineID>2</ram:LineID>
                  </ram:AssociatedDocumentLineDocument>
                  <ram:SpecifiedTradeProduct>
                    <ram:GlobalID schemeID=\"0160\">3518370200090</ram:GlobalID>
                    <ram:SellerAssignedID>BRAIS300</ram:SellerAssignedID>
                    <ram:Name>Biscuits aux raisins 300g</ram:Name>
                  </ram:SpecifiedTradeProduct>
                  <ram:SpecifiedLineTradeAgreement>
                    <ram:GrossPriceProductTradePrice>
                      <ram:ChargeAmount>3.20</ram:ChargeAmount>
                    </ram:GrossPriceProductTradePrice>
                    <ram:NetPriceProductTradePrice>
                      <ram:ChargeAmount>3.20</ram:ChargeAmount>
                    </ram:NetPriceProductTradePrice>
                  </ram:SpecifiedLineTradeAgreement>
                  <ram:SpecifiedLineTradeDelivery>
                    <ram:BilledQuantity unitCode=\"C62\">15.000</ram:BilledQuantity>
                  </ram:SpecifiedLineTradeDelivery>
                  <ram:SpecifiedLineTradeSettlement>
                    <ram:ApplicableTradeTax>
                      <ram:TypeCode>VAT</ram:TypeCode>
                      <ram:CategoryCode>S</ram:CategoryCode>
                      <ram:RateApplicablePercent>5.50</ram:RateApplicablePercent>
                    </ram:ApplicableTradeTax>
                    <ram:SpecifiedTradeSettlementLineMonetarySummation>
                      <ram:LineTotalAmount>48.00</ram:LineTotalAmount>
                    </ram:SpecifiedTradeSettlementLineMonetarySummation>
                  </ram:SpecifiedLineTradeSettlement>
                </ram:IncludedSupplyChainTradeLineItem>
                <ram:IncludedSupplyChainTradeLineItem>
                  <ram:AssociatedDocumentLineDocument>
                    <ram:LineID>3</ram:LineID>
                  </ram:AssociatedDocumentLineDocument>
                  <ram:SpecifiedTradeProduct>
                    <ram:SellerAssignedID>HOLANCL</ram:SellerAssignedID>
                    <ram:Name>Huile d'olive à l'ancienne</ram:Name>
                  </ram:SpecifiedTradeProduct>
                  <ram:SpecifiedLineTradeAgreement>
                    <ram:GrossPriceProductTradePrice>
                      <ram:ChargeAmount>19.80</ram:ChargeAmount>
                    </ram:GrossPriceProductTradePrice>
                    <ram:NetPriceProductTradePrice>
                      <ram:ChargeAmount>19.80</ram:ChargeAmount>
                    </ram:NetPriceProductTradePrice>
                  </ram:SpecifiedLineTradeAgreement>
                  <ram:SpecifiedLineTradeDelivery>
                    <ram:BilledQuantity unitCode=\"LTR\">25.000</ram:BilledQuantity>
                  </ram:SpecifiedLineTradeDelivery>
                  <ram:SpecifiedLineTradeSettlement>
                    <ram:ApplicableTradeTax>
                      <ram:TypeCode>VAT</ram:TypeCode>
                      <ram:CategoryCode>S</ram:CategoryCode>
                      <ram:RateApplicablePercent>5.50</ram:RateApplicablePercent>
                    </ram:ApplicableTradeTax>
                    <ram:SpecifiedTradeSettlementLineMonetarySummation>
                      <ram:LineTotalAmount>495.00</ram:LineTotalAmount>
                    </ram:SpecifiedTradeSettlementLineMonetarySummation>
                  </ram:SpecifiedLineTradeSettlement>
                </ram:IncludedSupplyChainTradeLineItem>
                <ram:ApplicableHeaderTradeAgreement>
                  <ram:SellerTradeParty>
                    <ram:Name>Au bon moulin</ram:Name>
                    <ram:SpecifiedLegalOrganization>
                      <ram:ID schemeID=\"0002\">99999999800010</ram:ID>
                    </ram:SpecifiedLegalOrganization>
                    <ram:DefinedTradeContact>
                      <ram:PersonName>Tony Dubois</ram:PersonName>
                      <ram:TelephoneUniversalCommunication>
                        <ram:CompleteNumber>+33 4 72 07 08 56</ram:CompleteNumber>
                      </ram:TelephoneUniversalCommunication>
                      <ram:EmailURIUniversalCommunication>
                        <ram:URIID schemeID=\"SMTP\">tony.dubois@aubonmoulin.fr</ram:URIID>
                      </ram:EmailURIUniversalCommunication>
                    </ram:DefinedTradeContact>
                    <ram:PostalTradeAddress>
                      <ram:PostcodeCode>84340</ram:PostcodeCode>
                      <ram:LineOne>1242 chemin de l'olive</ram:LineOne>
                      <ram:CityName>Malaucène</ram:CityName>
                      <ram:CountryID>FR</ram:CountryID>
                    </ram:PostalTradeAddress>
                    <ram:SpecifiedTaxRegistration>
                      <ram:ID schemeID=\"VA\">FR11999999998</ram:ID>
                    </ram:SpecifiedTaxRegistration>
                  </ram:SellerTradeParty>
                  <ram:BuyerTradeParty>
                    <ram:Name>Ma jolie boutique</ram:Name>
                    <ram:SpecifiedLegalOrganization>
                      <ram:ID schemeID=\"0002\">78787878400035</ram:ID>
                    </ram:SpecifiedLegalOrganization>
                    <ram:DefinedTradeContact>
                      <ram:PersonName>Alexandre Payet</ram:PersonName>
                      <ram:TelephoneUniversalCommunication>
                        <ram:CompleteNumber>+33 4 72 07 08 67</ram:CompleteNumber>
                      </ram:TelephoneUniversalCommunication>
                      <ram:EmailURIUniversalCommunication>
                        <ram:URIID schemeID=\"SMTP\">alexandre.payet@majolieboutique.net</ram:URIID>
                      </ram:EmailURIUniversalCommunication>
                    </ram:DefinedTradeContact>
                    <ram:PostalTradeAddress>
                      <ram:PostcodeCode>69001</ram:PostcodeCode>
                      <ram:LineOne>35 rue de la République</ram:LineOne>
                      <ram:CityName>Lyon</ram:CityName>
                      <ram:CountryID>FR</ram:CountryID>
                    </ram:PostalTradeAddress>
                    <ram:SpecifiedTaxRegistration>
                      <ram:ID schemeID=\"VA\">FR19787878784</ram:ID>
                    </ram:SpecifiedTaxRegistration>
                  </ram:BuyerTradeParty>
                  <ram:BuyerOrderReferencedDocument>
                    <ram:IssuerAssignedID>PO445</ram:IssuerAssignedID>
                  </ram:BuyerOrderReferencedDocument>
                  <ram:ContractReferencedDocument>
                    <ram:IssuerAssignedID>MSPE2017</ram:IssuerAssignedID>
                  </ram:ContractReferencedDocument>
                </ram:ApplicableHeaderTradeAgreement>
                <ram:ApplicableHeaderTradeDelivery>
                  <ram:ShipToTradeParty>
                    <ram:PostalTradeAddress>
                      <ram:PostcodeCode>69001</ram:PostcodeCode>
                      <ram:LineOne>35 rue de la République</ram:LineOne>
                      <ram:CityName>Lyon</ram:CityName>
                      <ram:CountryID>FR</ram:CountryID>
                    </ram:PostalTradeAddress>
                  </ram:ShipToTradeParty>
                </ram:ApplicableHeaderTradeDelivery>
                <ram:ApplicableHeaderTradeSettlement>
                  <ram:PaymentReference>FA-2017-0010</ram:PaymentReference>
                  <ram:InvoiceCurrencyCode>EUR</ram:InvoiceCurrencyCode>
                  <ram:SpecifiedTradeSettlementPaymentMeans>
                    <ram:TypeCode>30</ram:TypeCode>
                    <ram:Information>Virement sur compte Banque Fiducial</ram:Information>
                    <ram:PayeePartyCreditorFinancialAccount>
                      <ram:IBANID>FR2012421242124212421242124</ram:IBANID>
                    </ram:PayeePartyCreditorFinancialAccount>
                    <ram:PayeeSpecifiedCreditorFinancialInstitution>
                      <ram:BICID>FIDCFR21XXX</ram:BICID>
                    </ram:PayeeSpecifiedCreditorFinancialInstitution>
                  </ram:SpecifiedTradeSettlementPaymentMeans>
                  <ram:ApplicableTradeTax>
                    <ram:CalculatedAmount>16.38</ram:CalculatedAmount>
                    <ram:TypeCode>VAT</ram:TypeCode>
                    <ram:BasisAmount>81.90</ram:BasisAmount>
                    <ram:CategoryCode>S</ram:CategoryCode>
                    <ram:DueDateTypeCode>5</ram:DueDateTypeCode>
                    <ram:RateApplicablePercent>20.00</ram:RateApplicablePercent>
                  </ram:ApplicableTradeTax>
                  <ram:ApplicableTradeTax>
                    <ram:CalculatedAmount>29.87</ram:CalculatedAmount>
                    <ram:TypeCode>VAT</ram:TypeCode>
                    <ram:BasisAmount>543.00</ram:BasisAmount>
                    <ram:CategoryCode>S</ram:CategoryCode>
                    <ram:DueDateTypeCode>5</ram:DueDateTypeCode>
                    <ram:RateApplicablePercent>5.50</ram:RateApplicablePercent>
                  </ram:ApplicableTradeTax>
                  <ram:SpecifiedTradePaymentTerms>
                    <ram:Description>30% d'acompte, solde à 30 j</ram:Description>
                    <ram:DueDateDateTime>
                      <udt:DateTimeString format=\"102\">20171213</udt:DateTimeString>
                    </ram:DueDateDateTime>
                  </ram:SpecifiedTradePaymentTerms>
                  <ram:SpecifiedTradeSettlementHeaderMonetarySummation>
                    <ram:LineTotalAmount>624.90</ram:LineTotalAmount>
                    <ram:TaxBasisTotalAmount>624.90</ram:TaxBasisTotalAmount>
                    <ram:TaxTotalAmount currencyID=\"EUR\">46.25</ram:TaxTotalAmount>
                    <ram:GrandTotalAmount>671.15</ram:GrandTotalAmount>
                    <ram:TotalPrepaidAmount>201.00</ram:TotalPrepaidAmount>
                    <ram:DuePayableAmount>470.15</ram:DuePayableAmount>
                  </ram:SpecifiedTradeSettlementHeaderMonetarySummation>
                </ram:ApplicableHeaderTradeSettlement>
              </rsm:SupplyChainTradeTransaction>
            </rsm:CrossIndustryInvoice>";

        $document = new \DOMDocument();
        $document->loadXML($xmlEn16931);

        $xsdFeedback = CrossIndustryInvoiceUtils::validateXSD($document, 'EN16931');
        $this->assertTrue($xsdFeedback);
    }
    
    
    /**
     * @testdox Create EN-16931 profile with mandatory fields
     */
    public function testCreateEN16931ProfileWithMandatoryFields(): void
    {
        $invoice = new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::EN16931)
                )
            ),
            new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE)),
                    new BuyerTradeParty('BuyerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40),
                    [
                        new HeaderApplicableTradeTax(100, 100, VatCategory::STANDARD_RATE),
                    ],
                ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('InvoiceLineIdentifier')
                        ),
                        new SpecifiedTradeProduct('SpecifiedTradProduct'),
                        new SpecifiedLineTradeAgreement(
                            new NetPriceProductTradePrice(100)
                        ),
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(1, UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                        ),
                        new SpecifiedLineTradeSettlement(
                            new ApplicableTradeTax(VatCategory::STANDARD_RATE),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        )
                    ),
                ],
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }

    /**
     * @testdox Create EN16931 profile with mandatory and optional fields
     */
    public function testCreateEN16931ProfileWithMandatoryAndOptionalFields(): void
    {
        $invoice = new CrossIndustryInvoice(
            (new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::EN16931)
                )
            ))
                ->setBusinessProcessSpecifiedDocumentContextParameter(new BusinessProcessSpecifiedDocumentContextParameter('BusinessProcess1')),
            (new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ))
                ->setIncludedNotes([
                    (new DocumentIncludedNote('DocumentIncludedNote'))->setSubjectCode(InvoiceNoteCode::NOTE),
                ]),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty(
                        'SellerTradePartyName',
                        (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                            ->setPostcodeCode('PostcodeCode')
                            ->setLineOne('LineOne')
                            ->setLineTwo('LineTwo')
                            ->setLineThree('Line3')
                            ->setCityName('CityName')
                            ->setCountrySubDivisionName('CountrySubDivisionName')
                    ),
                    new BuyerTradeParty(
                        'BuyerTradePartyName',
                        (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                            ->setPostcodeCode('PostcodeCode')
                            ->setLineOne('LineOne')
                            ->setLineTwo('LineTwo')
                            ->setLineThree('Line3')
                            ->setCityName('CityName')
                            ->setCountrySubDivisionName('CountrySubDivisionName')
                    )
                ),
                (new ApplicableHeaderTradeDelivery())
                    ->setShipToTradeParty(
                        (new ShipToTradeParty())
                            ->setIdentifier(new LocationIdentifier('LocationIdentifer'))
                            ->setName('ShipToTradeName')
                            ->setGlobalIdentifier(
                                new LocationGlobalIdentifier('LocationGlobalIdentifier', InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN)
                            )
                            ->setPostalTradeAddress(
                                (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                                    ->setPostcodeCode('PostcodeCode')
                                    ->setLineOne('LineOne')
                                    ->setLineTwo('LineTwo')
                                    ->setLineThree('Line3')
                                    ->setCityName('CityName')
                                    ->setCountrySubDivisionName('CountrySubDivisionName')
                            )
                    )
                    ->setActualDeliverySupplyChainEvent(
                        new ActualDeliverySupplyChainEvent(
                            new OccurrenceDateTime(new \DateTime()))
                    )
                    ->setDespatchAdviceReferencedDocument(
                        new DespatchAdviceReferencedDocument(
                            new DespatchAdviceReference('DespatchAdviceReference')
                        )
                    )
                    ->setReceivingAdviceReferencedDocument(
                        new ReceivingAdviceReferencedDocument(
                            new ReceivingAdviceReference('ReceivingAdviceReference')
                        )
                    ),
                (new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    (new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40))
                        ->setRoundingAmount(40)
                        ->setChargeTotalAmount(20)
                        ->setAllowanceTotalAmount(10)
                        ->setTaxTotalAmountCurrency(new TaxTotalAmount(10, CurrencyCode::EURO))
                        ->setTotalPrepaidAmount(40),
                    [
                        (new HeaderApplicableTradeTax(100, 100, VatCategory::STANDARD_RATE))
                            ->setTaxPointDate(new TaxPointDate(new \DateTime()))
                            ->setExemptionReason('ExemptionReason')
                            ->setExemptionReasonCode(VatExoneration::NOT_SUBJECT_TO_VAT)
                            ->setDueDateTypeCode(DateCode2475::INVOICE_DATE)
                            ->setRateApplicablePercent(50),
                    ],
                ))
                    ->setCreditorReferenceIdentifier(new BankAssignedCreditorIdentifier('BankAssignedCreditorIdentifier'))
                    ->setPaymentReference('PaymentReference')
                    ->setTaxCurrencyCode(CurrencyCode::EURO)
                    ->setPayeeTradeParty(
                        (new PayeeTradeParty('PayeeTradePartyName'))
                            ->setIdentifier(new PayeeIdentifier('PayeeIdentifier'))
                            ->setGlobalIdentifier(new PayeeGlobalIdentifier('PayeeGlobalIdentifier', InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN))
                            ->setSpecifiedLegalOrganization(
                                new PayeeSpecifiedLegalOrganization(
                                    new LegalRegistrationIdentifier('LegalRegistrationIdentifier', InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN)
                                )
                            )
                    )
                    ->setSpecifiedTradeSettlementPaymentMeans(
                        (new SpecifiedTradeSettlementPaymentMeans(PaymentMeansCode::ACCEPTED_BILL_OF_EXCHANGE))
                            ->setInformation('Information')
                            ->setApplicableTradeSettlementFinancialCard(
                                (new ApplicableTradeSettlementFinancialCard('ApplicableTradeSettlementFinancialCardIdentifier'))
                                    ->setCardholderName('CardholderName')
                            )
                            ->setPayerPartyDebtorFinancialAccount(
                                new PayerPartyDebtorFinancialAccount(
                                    new DebitedAccountIdentifier('DebitedAccountIdentifier')
                                )
                            )
                            ->setPayeePartyCreditorFinancialAccount(
                                (new PayeePartyCreditorFinancialAccount())
                                    ->setIbanIdentifier(new PaymentAccountIdentifier('PaymentAccountIdentifier'))
                                    ->setAccountName('accountName')
                                    ->setProprietaryIdentifier(new PaymentAccountIdentifier('PaymentAccountIdentifier (proprietary)'))
                            )
                            ->setPayeeSpecifiedCreditorFinancialInstitution(
                                new PayeeSpecifiedCreditorFinancialInstitution(
                                    new PaymentServiceProviderIdentifier('PaymentServiceProviderIdentifier')
                                )
                            )
                    )
                    ->setBillingSpecifiedPeriod(
                        (new BillingSpecifiedPeriod())
                            ->setStartDateTime(new StartDateTime(new \DateTime()))
                            ->setEndDateTime(new EndDateTime(new \DateTime()))
                    )
                    ->setSpecifiedTradeAllowances([
                        (new SpecifiedTradeAllowance(
                            100,
                            (new CategoryTradeTax(VatCategory::STANDARD_RATE))
                                ->setRateApplicablePercent(new Percentage(50))
                        ))
                            ->setBasisAmount(100)
                            ->setReason('ReasonAllowanceHeader1')
                            ->setReasonCode(AllowanceReasonCode::DISCOUNT)
                            ->setCalculationPercent(50),
                    ])
                    ->setSpecifiedTradeCharges([
                        (new SpecifiedTradeCharge(
                            50,
                            (new CategoryTradeTax(VatCategory::STANDARD_RATE))
                                ->setRateApplicablePercent(new Percentage(20))
                        ))
                            ->setBasisAmount(50)
                            ->setReason('ReasonChargeHeader1')
                            ->setReasonCode(ChargeReasonCode::ACCEPTANCE)
                            ->setCalculationPercent(20),
                    ])
                    ->setSpecifiedTradePaymentTerms(
                        (new SpecifiedTradePaymentTerms())
                            ->setDirectDebitMandateIdentifier(new MandateReferenceIdentifier('MandateReferenceIdentifier'))
                            ->setDescription('description')
                            ->setDueDateDateTime(new DueDateDateTime(new \DateTime()))
                    )
                    ->setInvoiceReferencedDocument(
                        (new InvoiceReferencedDocument(
                            new PrecedingInvoiceReference('PrecedingInvoiceReference'))
                        )
                            ->setFormattedIssueDateTime(new FormattedIssueDateTime(new \DateTime()))
                    )
                    ->setReceivableSpecifiedTradeAccountingAccount(new ReceivableSpecifiedTradeAccountingAccount('ReceivableSpecifiedTradeAccountingAccount')),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('InvoiceLineIdentifier')
                        ),
                        new SpecifiedTradeProduct('SpecifiedTradProduct'),
                        (new SpecifiedLineTradeAgreement(
                            (new NetPriceProductTradePrice(100))->setBasisQuantity((new BasisQuantity(1))->setUnitCode(UnitOfMeasurement::ACCOUNTING_UNIT_REC20))
                        ))->setGrossPriceProductTradePrice(
                            (new GrossPriceProductTradePrice(100))
                                ->setBasisQuantity(
                                    (new BasisQuantity(100))
                                        ->setUnitCode(UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                                )
                                ->setAppliedTradeAllowanceCharge(new AppliedTradeAllowanceCharge(100))
                        )
                            ->setBuyerOrderReferencedDocument(
                                (new LineBuyerOrderReferencedDocument())
                                    ->setLineIdentifier(new PurchaseOrderLineReference('PurchaseOrderLineReference'))
                            ),
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(1, UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                        ),
                        (new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(VatCategory::STANDARD_RATE))
                                ->setRateApplicablePercent(20),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        ))
                            ->setBillingSpecifiedPeriod(
                                (new BillingSpecifiedPeriod())
                                    ->setStartDateTime(new StartDateTime(new \DateTime()))
                                    ->setEndDateTime(new EndDateTime(new \DateTime()))
                            )
                            ->setSpecifiedTradeAllowances([
                                (new LineSpecifiedTradeAllowance(50))
                                    ->setReason('ReasonAllowance1')
                                    ->setReasonCode(AllowanceReasonCode::STANDARD)
                                    ->setBasisAmount(50)
                                    ->setCalculationPercent(100),
                            ])
                            ->setSpecifiedTradeCharges([
                                (new LineSpecifiedTradeCharge(50))
                                    ->setReason('ReasonCharge1')
                                    ->setReasonCode(ChargeReasonCode::ACCEPTANCE)
                                    ->setBasisAmount(50)
                                    ->setCalculationPercent(100),
                            ])
                            ->setReceivableSpecifiedTradeAccountingAccount(new ReceivableSpecifiedTradeAccountingAccount('ReceivableSpecifiedTradeAccountingAccount'))
                            ->setAdditionalReferencedDocument(
                                (new AdditionalReferencedDocumentInvoiceLineObjectIdentifier(
                                    new ObjectIdentifier('AdditionalReferencedDocument', ObjectSchemeCode::ACCOUNT_NUMBER)
                                ))->setReferenceTypeCode(ObjectSchemeCode::ACCOUNT_NUMBER)
                            )
                    ),
                ],
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }

    /**
     * @testdox Create EN16931 profile from XML mandatory data
     */
    public function testCreateEN16931ProfileFromXMLMandatoryData(): void
    {
        $invoiceToConvert = new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::EN16931)
                )
            ),
            new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE)),
                    new BuyerTradeParty('BuyerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(40, 40, 40, 40),
                    [
                        new HeaderApplicableTradeTax(100, 100, VatCategory::STANDARD_RATE),
                    ],
                ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('InvoiceLineIdentifier')
                        ),
                        new SpecifiedTradeProduct('SpecifiedTradProduct'),
                        new SpecifiedLineTradeAgreement(
                            new NetPriceProductTradePrice(100)
                        ),
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(1, UnitOfMeasurement::ACCOUNTING_UNIT_REC20)
                        ),
                        new SpecifiedLineTradeSettlement(
                            new ApplicableTradeTax(VatCategory::STANDARD_RATE),
                            new SpecifiedTradeSettlementLineMonetarySummation(100)
                        )
                    ),
                ],
            )
        );

        $xmlInvoice = $invoiceToConvert->toXML();

        $document = new \DOMDocument();
        $document->loadXML($xmlInvoice->saveXML());

        $invoice = CrossIndustryInvoice::fromXML($document);
        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);
    }

    /**
     * @testdox Generate CII HTML with EN-16931 CII
     */
    public function testGenerateHTMLWithEN16931CII(): void
    {
        $invoice = new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::EN16931)
                )
            ),
            (new ExchangedDocument(
                new InvoiceIdentifier('FA-2017-0010'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime('2017-11-13'))
            ))->setIncludedNotes([new DocumentIncludedNote('Franco de port (commande > 300 € HT)')]),
            new SupplyChainTradeTransaction(
                (new ApplicableHeaderTradeAgreement(
                    (new SellerTradeParty(
                        'Au bon moulin',
                        (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                            ->setLineOne('1242 chemin de l\'olive')
                            ->setPostcodeCode('84340')
                            ->setCityName('Malaucène')
                    ))
                        ->setSpecifiedLegalOrganization(
                            (new SellerSpecifiedLegalOrganization())
                                ->setIdentifier(new LegalRegistrationIdentifier('99999999800010', InternationalCodeDesignator::SYSTEM_INFORMATION_ET_REPERTOIRE_DES_ENTREPRISE_ET_DES_ETABLISSEMENTS_SIRENE))
                        )
                        ->setDefinedTradeContact(
                            (new DefinedTradeContact())
                                ->setPersonName('Tony Dubois')
                                ->setTelephoneUniversalCommunication(new TelephoneUniversalCommunication('+33 4 72 07 08 56'))
                                ->setEmailURIUniversalCommunication(new EmailURIUniversalCommunication('tony.dubois@aubonmoulin.fr'))
                        )
                        ->setSpecifiedTaxRegistrationVA(
                            new SpecifiedTaxRegistrationVA(new VatIdentifier('FR11999999998'))
                        )
                    ,
                    (new BuyerTradeParty(
                        'Ma jolie boutique',
                        (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                            ->setPostcodeCode('69001')
                            ->setLineOne('35 rue de la République')
                            ->setCityName('Lyon')
                    ))
                        ->setDefinedTradeContact(
                            (new DefinedTradeContact())
                                ->setPersonName('Alexandre Payet')
                                ->setTelephoneUniversalCommunication(new TelephoneUniversalCommunication('+33 4 72 07 08 67'))
                                ->setEmailURIUniversalCommunication(new EmailURIUniversalCommunication('alexandre.payet@majolieboutique.net'))
                        )
                        ->setSpecifiedLegalOrganization(
                            new BuyerSpecifiedLegalOrganization(
                                new LegalRegistrationIdentifier('78787878400035', InternationalCodeDesignator::SYSTEM_INFORMATION_ET_REPERTOIRE_DES_ENTREPRISE_ET_DES_ETABLISSEMENTS_SIRENE)
                            )
                        )
                        ->setSpecifiedTaxRegistrationVA(
                            new SpecifiedTaxRegistrationVA(
                                new VatIdentifier('FR19787878784')
                            )
                        )
                ))
                    ->setBuyerOrderReferencedDocument(new BuyerOrderReferencedDocument(new PurchaseOrderReference('PO445')))
                    ->setContractReferencedDocument(new ContractReferencedDocument(new ContractReference('MSPE2017')))
                ,
                (new ApplicableHeaderTradeDelivery())
                    ->setShipToTradeParty(
                        (new ShipToTradeParty())->setPostalTradeAddress(
                            (new PostalTradeAddress(CountryAlpha2Code::FRANCE))
                                ->setLineOne('35 rue de la République')
                                ->setCityName('Lyon')
                                ->setPostcodeCode('69001')
                        )
                    ),
                (new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    (new SpecifiedTradeSettlementHeaderMonetarySummation(624.90, 671.15, 470.15, 624.90))
                        ->setTaxTotalAmount(new TaxTotalAmount(46.25, CurrencyCode::EURO))
                        ->setTotalPrepaidAmount(201.00),
                    [
                        (new HeaderApplicableTradeTax(16.38, 81.90, VatCategory::STANDARD_RATE))
                            ->setRateApplicablePercent(20)
                            ->setDueDateTypeCode(DateCode2475::INVOICE_DATE)
                        ,
                        (new HeaderApplicableTradeTax(29.87, 543, VatCategory::STANDARD_RATE))
                            ->setRateApplicablePercent(5.5)
                            ->setDueDateTypeCode(DateCode2475::INVOICE_DATE)
                    ],
                ))
                    ->setPaymentReference('FA-2017-0010')
                    ->setSpecifiedTradeSettlementPaymentMeans(
                        (new SpecifiedTradeSettlementPaymentMeans(PaymentMeansCode::CREDIT_TRANSFER))
                            ->setInformation('Virement sur compte Banque Fiducial')
                            ->setPayeePartyCreditorFinancialAccount(
                                (new PayeePartyCreditorFinancialAccount())
                                    ->setIbanIdentifier(new PaymentAccountIdentifier('FR2012421242124212421242124'))
                            )
                            ->setPayeeSpecifiedCreditorFinancialInstitution(
                                new PayeeSpecifiedCreditorFinancialInstitution(new PaymentServiceProviderIdentifier('FIDCFR21XXX'))
                            )
                    )
                    ->setSpecifiedTradePaymentTerms(
                        (new SpecifiedTradePaymentTerms())
                            ->setDescription('30% d\'acompte, solde à 30 j')
                            ->setDueDateDateTime(new DueDateDateTime(new \DateTimeImmutable('2017-12-13')))
                    ),
                [
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('1')
                        ),
                        (new SpecifiedTradeProduct('Nougat de l\'Abbaye 250g'))
                            ->setSellerAssignedIdentifier(new SellerItemIdentifier('NOUG250'))
                            ->setGlobalIdentifier(new StandardItemIdentifier('3518370400049', InternationalCodeDesignator::GTIN_GLOBAL_TRADE_ITEM_NUMBER))
                        ,
                        (new SpecifiedLineTradeAgreement(
                            new NetPriceProductTradePrice(4.10)
                        ))
                            ->setGrossPriceProductTradePrice(
                                (new GrossPriceProductTradePrice(4.55))
                                    ->setAppliedTradeAllowanceCharge(
                                        new AppliedTradeAllowanceCharge(0.45)
                                    )
                            )
                        ,
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(20, UnitOfMeasurement::ONE_REC20)
                        ),
                        new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(VatCategory::STANDARD_RATE))
                                ->setRateApplicablePercent(20),
                            new SpecifiedTradeSettlementLineMonetarySummation(81.90)
                        )
                    ),
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('2')
                        ),
                        (new SpecifiedTradeProduct('Biscuits aux raisins 300g'))
                            ->setSellerAssignedIdentifier(new SellerItemIdentifier('BRAIS300'))
                            ->setGlobalIdentifier(new StandardItemIdentifier('3518370200090', InternationalCodeDesignator::GTIN_GLOBAL_TRADE_ITEM_NUMBER))
                        ,
                        (new SpecifiedLineTradeAgreement(
                            new NetPriceProductTradePrice(3.20)
                        ))
                            ->setGrossPriceProductTradePrice((new GrossPriceProductTradePrice(3.20)))
                        ,
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(15, UnitOfMeasurement::ONE_REC20)
                        ),
                        new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(VatCategory::STANDARD_RATE))
                                ->setRateApplicablePercent(5.50),
                            new SpecifiedTradeSettlementLineMonetarySummation(48)
                        )
                    ),
                    new IncludedSupplyChainTradeLineItem(
                        new AssociatedDocumentLineDocument(
                            new InvoiceLineIdentifier('3')
                        ),
                        (new SpecifiedTradeProduct('Huile d\'olive à l\'ancienne'))
                            ->setSellerAssignedIdentifier(new SellerItemIdentifier('HOLANCL'))
                        ,
                        (new SpecifiedLineTradeAgreement(
                            new NetPriceProductTradePrice(19.80)
                        ))
                            ->setGrossPriceProductTradePrice((new GrossPriceProductTradePrice(19.80)))
                        ,
                        new SpecifiedLineTradeDelivery(
                            new BilledQuantity(25, UnitOfMeasurement::LITRE_REC20)
                        ),
                        new SpecifiedLineTradeSettlement(
                            (new ApplicableTradeTax(VatCategory::STANDARD_RATE))
                                ->setRateApplicablePercent(5.50),
                            new SpecifiedTradeSettlementLineMonetarySummation(495)
                        )
                    ),
                ],
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $html = $invoice->toHTML(context: ['invoice_logo' => 'image/invoice_logo.png']);
        $this->assertIsString($html);

        $this_directory = dirname(__FILE__);
        $fp = fopen($this_directory . "/invoice.html", "w");
        fwrite($fp, $html);
        fclose($fp);
    }
}