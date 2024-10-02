<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Utils;

use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;

class CrossIndustryInvoiceUtils
{
    public const XSD_FOLDER = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'xsd' . \DIRECTORY_SEPARATOR;

    public const SPECIFICATION_TO_XSD = [
        'MINIMUM'  => self::XSD_FOLDER . 'Minimum' . \DIRECTORY_SEPARATOR . 'FACTUR-X_MINIMUM.xsd',
        'BASICWL'  => self::XSD_FOLDER . 'BasicWL' . \DIRECTORY_SEPARATOR . 'FACTUR-X_BASIC-WL.xsd',
        'BASIC'    => self::XSD_FOLDER . 'Basic' . \DIRECTORY_SEPARATOR . 'FACTUR-X_BASIC.xsd',
        'EN16931'  => self::XSD_FOLDER . 'EN16931' . \DIRECTORY_SEPARATOR . 'FACTUR-X_EN16931.xsd',
        'EXTENDED' => self::XSD_FOLDER . 'Extended' . \DIRECTORY_SEPARATOR . 'FACTUR-X_EXTENDED.xsd',
    ];

    /**
     * @return array<int, \LibXMLError>
     */
    public static function validateXSD(\DOMDocument $xml, string $specificationIdentifier): array
    {
        if (!\array_key_exists($specificationIdentifier, self::SPECIFICATION_TO_XSD)) {
            throw new \Exception('This profile does not exist.');
        }

        $errors = [];

        libxml_use_internal_errors(true);

        if (!$xml->schemaValidate(self::SPECIFICATION_TO_XSD[$specificationIdentifier])) {
            $errors = libxml_get_errors();
            libxml_clear_errors();
        }

        libxml_use_internal_errors(false);

        return $errors;
    }

    public static function getProfile(\DOMDocument $xml): string
    {
        $xpath = new \DOMXPath($xml);

        /** @var \DOMNodeList<\DOMElement> $elements */
        $elements = $xpath->query('//rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID');

        if (0 === $elements->count()) {
            throw new \Exception('This XML is not a Factur-X XML because it misses the XML
                tag ExchangedDocumentContext/GuidelineSpecifiedDocumentContextParameter/ID.');
        }

        $documentIdentifierItem = $elements->item(0);

        if (!$documentIdentifierItem instanceof \DOMElement) {
            throw new \Exception('The XML doesn\'t contain a valid version.');
        }

        $documentIdentifier = $documentIdentifierItem->nodeValue;

        if (!\is_string($documentIdentifier)) {
            throw new \Exception('The XML doesn\'t contain a valid version.');
        }

        $explodedDocumentIdentifier = explode(':', mb_strtoupper($documentIdentifier));

        $profile = end($explodedDocumentIdentifier);

        if (!$profile) {
            throw new \Exception('The XML doesn\'t contain a valid version.');
        }

        $specificationIdentifierReflectionClass = new \ReflectionClass(SpecificationIdentifier::class);
        $specificationIdentifiers               = array_change_key_case($specificationIdentifierReflectionClass->getConstants(), \CASE_UPPER);

        if (!\array_key_exists($profile, $specificationIdentifiers)) {
            $profile = prev($explodedDocumentIdentifier);

            if (!$profile) {
                throw new \Exception('The XML doesn\'t contain a valid version.');
            }
        }

        if (!\array_key_exists($profile, $specificationIdentifiers)) {
            throw new \Exception(\sprintf('Invalid version : %s', $documentIdentifier));
        }

        return $profile;
    }
}
