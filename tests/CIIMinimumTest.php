<?php

namespace Tiime\CrossIndustryInvoice\Tests;

use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\DataType\BusinessProcessSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\ExchangedDocumentContext;
use Tiime\CrossIndustryInvoice\DataType\GuidelineSpecifiedDocumentContextParameter;
use Tiime\CrossIndustryInvoice\DataType\IssueDateTime;
use Tiime\CrossIndustryInvoice\DataType\Minimum\ApplicableHeaderTradeAgreement;
use Tiime\CrossIndustryInvoice\DataType\Minimum\ApplicableHeaderTradeDelivery;
use Tiime\CrossIndustryInvoice\DataType\Minimum\ApplicableHeaderTradeSettlement;
use Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\Minimum\BuyerTradeParty;
use Tiime\CrossIndustryInvoice\DataType\Minimum\ExchangedDocument;
use Tiime\CrossIndustryInvoice\DataType\Minimum\PostalTradeAddress;
use Tiime\CrossIndustryInvoice\DataType\Minimum\SellerSpecifiedLegalOrganization;
use Tiime\CrossIndustryInvoice\DataType\Minimum\SellerTradeParty;
use Tiime\CrossIndustryInvoice\DataType\Minimum\SpecifiedTradeSettlementHeaderMonetarySummation;
use Tiime\CrossIndustryInvoice\DataType\Minimum\SupplyChainTradeTransaction;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTaxRegistrationVA;
use Tiime\CrossIndustryInvoice\Minimum\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\Utils\CrossIndustryInvoiceUtils;
use Tiime\EN16931\DataType\CountryAlpha2Code;
use Tiime\EN16931\DataType\CurrencyCode;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;
use Tiime\EN16931\DataType\InternationalCodeDesignator;
use Tiime\EN16931\DataType\InvoiceTypeCode;

class CIIMinimumTest extends TestCase
{
    public function testValidateXsdError(): void
    {
        $xml = "<?xml version='1.0' encoding='UTF-8'?>
            <rsm:CrossIndustryInvoice xmlns:qdt=\"urn:un:unece:uncefact:data:standard:QualifiedDataType:100\" xmlns:ram=\"urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100\" xmlns:rsm=\"urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100\" xmlns:udt=\"urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
              <rsm:ExchangedDocumentContext>
                <ram:GuidelineSpecifiedDocumentContextParameter>
                  <ram:ID>urn:factur-x.eu:1p0:minimum</ram:ID>
                </ram:GuidelineSpecifiedDocumentContextParameter>
              </rsm:ExchangedDocumentContext>
            </rsm:CrossIndustryInvoice>";

        $document = new \DOMDocument();
        $document->loadXML($xml);

        $xsdErrors = CrossIndustryInvoiceUtils::validateXSD($document, 'MINIMUM');

        $this->assertCount(1, $xsdErrors);
    }

    public function testValidateXSDSuccess(): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/Fixtures/CIIMinimumInvoice.xml'));

        $xsdErrors = CrossIndustryInvoiceUtils::validateXSD($document, 'MINIMUM');

        $this->assertCount(0, $xsdErrors);
    }

    /**
     * @testdox Create Minimum profile with mandatory fields
     */
    public function testCreateMinimumProfileWithMandatoryFields(): void
    {
        $invoice = new CrossIndustryInvoice(
            new ExchangedDocumentContext(
                new GuidelineSpecifiedDocumentContextParameter(
                    new SpecificationIdentifier(SpecificationIdentifier::MINIMUM)
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
                    new BuyerTradeParty('BuyerTradePartyName'),
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(12, 13, 14)
                )
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }

    /**
     * @testdox Create Minimum profile with mandatory and optional fields
     */
    public function testCreateMinimumProfileWithMandatoryAndOptionalFields(): void
    {
        /** ExchangedDocumentContext part */
        $exchangedDocumentContext = (new ExchangedDocumentContext(
            new GuidelineSpecifiedDocumentContextParameter(
                new SpecificationIdentifier(SpecificationIdentifier::MINIMUM)
            )
        ))->setBusinessProcessSpecifiedDocumentContextParameter(
            new BusinessProcessSpecifiedDocumentContextParameter('BusinessProcess1')
        );

        /** BuyerTradeParty part */
        $buyerTradeParty                 = new BuyerTradeParty('BuyerTradePartyName');
        $buyerSpecifiedLegalOrganization = new BuyerSpecifiedLegalOrganization(
            new LegalRegistrationIdentifier(
                'LegalRegistrationBuyer',
                InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN
            )
        );
        $buyerTradeParty->setSpecifiedLegalOrganization($buyerSpecifiedLegalOrganization);

        /** SellerTradeParty part */
        $sellerTradeParty                 = new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE));
        $sellerSpecifiedLegalOrganization = new SellerSpecifiedLegalOrganization();
        $legalRegistrationIdentifier      = new LegalRegistrationIdentifier(
            'LegalRegistrationSeller',
            InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN
        );
        $sellerSpecifiedLegalOrganization->setIdentifier($legalRegistrationIdentifier);
        $sellerTradeParty->setSpecifiedTaxRegistrationVA(new SpecifiedTaxRegistrationVA(new VatIdentifier('FRVatId1')));
        $sellerTradeParty->setSpecifiedLegalOrganization(
            (new SellerSpecifiedLegalOrganization())
                ->setIdentifier(new LegalRegistrationIdentifier('SellerLegalRegistrationIdentifier', InternationalCodeDesignator::FRANCE_TELECOM_ATM_END_SYSTEM_ADDRESS_PLAN))
        );

        /** SpecifiedTradeSettlementHeaderMonetarySummation part */
        $specifiedTradeSettlementHeaderMonetarySummation = new SpecifiedTradeSettlementHeaderMonetarySummation(
            12,
            13,
            14
        );

        $invoice = new CrossIndustryInvoice(
            $exchangedDocumentContext,
            new ExchangedDocument(
                new InvoiceIdentifier('FA-1545'),
                InvoiceTypeCode::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement($sellerTradeParty, $buyerTradeParty),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCode::EURO,
                    $specifiedTradeSettlementHeaderMonetarySummation
                )
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }

    /**
     * @testdox Create Minimum profile from XML
     */
    public function testCreateMinimumProfileFromXML(): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/Fixtures/CIIMinimumInvoice.xml'));

        $invoice = CrossIndustryInvoice::fromXML($document);
        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);
    }
}
