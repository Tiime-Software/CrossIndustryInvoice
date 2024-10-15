<?php

namespace Tiime\CrossIndustryInvoice\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
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
use Tiime\EN16931\Codelist\CountryAlpha2Code;
use Tiime\EN16931\Codelist\CurrencyCodeISO4217;
use Tiime\EN16931\Codelist\InternationalCodeDesignator;
use Tiime\EN16931\Codelist\InvoiceTypeCodeUNTDID1001;
use Tiime\EN16931\DataType\Identifier\InvoiceIdentifier;
use Tiime\EN16931\DataType\Identifier\LegalRegistrationIdentifier;
use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;
use Tiime\EN16931\DataType\Identifier\VatIdentifier;

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

    #[DataProvider('provideMinimumXml')]
    public function testValidateXSDSuccess(string $filename): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/Fixtures/Minimum/' . $filename . '.xml'));

        $xsdErrors = CrossIndustryInvoiceUtils::validateXSD($document, 'MINIMUM');

        $this->assertCount(0, $xsdErrors);
    }

    #[TestDox('Create Minimum profile with mandatory fields')]
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
                InvoiceTypeCodeUNTDID1001::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement(
                    new SellerTradeParty('SellerTradePartyName', new PostalTradeAddress(CountryAlpha2Code::FRANCE)),
                    new BuyerTradeParty('BuyerTradePartyName'),
                ),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCodeISO4217::EURO,
                    new SpecifiedTradeSettlementHeaderMonetarySummation(12, 13, 14)
                )
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }

    #[TestDox('Create Minimum profile with mandatory and optional fields')]
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
        $buyerSpecifiedLegalOrganization = (new BuyerSpecifiedLegalOrganization())
            ->setIdentifier(
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
                InvoiceTypeCodeUNTDID1001::COMMERCIAL_INVOICE,
                new IssueDateTime(new \DateTime())
            ),
            new SupplyChainTradeTransaction(
                new ApplicableHeaderTradeAgreement($sellerTradeParty, $buyerTradeParty),
                new ApplicableHeaderTradeDelivery(),
                new ApplicableHeaderTradeSettlement(
                    CurrencyCodeISO4217::EURO,
                    $specifiedTradeSettlementHeaderMonetarySummation
                )
            )
        );

        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $xml = $invoice->toXML();
        $this->assertIsString($xml->saveXML());
    }

    #[TestDox('Create Minimum profile from XML')]
    #[DataProvider('provideMinimumXml')]
    public function testCreateMinimumProfileFromXML(string $filename): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/Fixtures/Minimum/' . $filename . '.xml'));

        $invoice = CrossIndustryInvoice::fromXML($document);
        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);
    }

    public static function provideMinimumXml(): iterable
    {
        yield '#1' => ['CIIMinimumInvoice'];
        yield '#2' => ['CIIMinimumInvoice_V7_01'];
        yield '#3' => ['CIIMinimumInvoice_V7_02'];
        yield '#4' => ['CIIMinimumInvoice_V7_03'];
        yield '#5' => ['CIIMinimumInvoice_V7_04'];
        yield '#6' => ['CIIMinimumInvoice_V7_05'];
        yield '#7' => ['CIIMinimumInvoice_V7_06'];
        yield '#8' => ['CIIMinimumInvoice_V7_07'];
        yield '#9' => ['CIIMinimumInvoice_V7_08'];
        yield '#10' => ['CIIMinimumInvoice_V7_09'];
        yield '#11' => ['CIIMinimumInvoice_V7_10'];
        yield '#12' => ['CIIMinimumInvoice_V7_11'];
    }
}
