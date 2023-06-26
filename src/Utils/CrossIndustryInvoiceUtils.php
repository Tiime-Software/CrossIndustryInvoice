<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\Utils;

use Tiime\EN16931\DataType\Identifier\SpecificationIdentifier;

class CrossIndustryInvoiceUtils
{
    public static function getProfile(\DOMDocument $xml): string
    {
        $xpath = new \DOMXPath($xml);

        /** @var \DOMNodeList<\DOMDocument> $elements */
        $elements = $xpath->query('//rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID');

        if (0 === $elements->count()) {
            throw new \Exception('This XML is not a Factur-X XML because it misses the XML
                tag ExchangedDocumentContext/GuidelineSpecifiedDocumentContextParameter/ID.');
        }

        $documentIdentifierItem = $elements->item(0);

        if (!$documentIdentifierItem instanceof \DOMDocument) {
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
            throw new \Exception(sprintf('Invalid version : %s', $documentIdentifier));
        }

        return $profile;
    }
}
