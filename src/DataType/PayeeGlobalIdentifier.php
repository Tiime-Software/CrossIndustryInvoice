<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice\DataType;

use Tiime\CrossIndustryInvoice\Utils\XPath;
use Tiime\EN16931\Codelist\InternationalCodeDesignator;
use Tiime\EN16931\DataType\Identifier\PayeeIdentifier;

/**
 * BT-60-0 & BT-60-1.
 */
readonly class PayeeGlobalIdentifier extends PayeeIdentifier
{
    protected const string XML_NODE = 'ram:GlobalID';

    public function __construct(string $value, InternationalCodeDesignator $scheme)
    {
        parent::__construct($value, $scheme);
    }

    public static function fromXML(XPath $xpath, \DOMElement $currentElement): ?self
    {
        $payeeGlobalIdentifierElements = $xpath->query(\sprintf('./%s', self::XML_NODE), $currentElement);

        if (0 === $payeeGlobalIdentifierElements->count()) {
            return null;
        }

        if ($payeeGlobalIdentifierElements->count() > 1) {
            throw new \Exception('Malformed');
        }

        /** @var \DOMElement $payeeGlobalIdentifierElement */
        $payeeGlobalIdentifierElement = $payeeGlobalIdentifierElements->item(0);

        $identifier = $payeeGlobalIdentifierElement->nodeValue;
        $scheme     = '' !== $payeeGlobalIdentifierElement->getAttribute('schemeID') ?
            InternationalCodeDesignator::tryFrom($payeeGlobalIdentifierElement->getAttribute('schemeID')) : null;

        if (null === $scheme) {
            throw new \Exception('Wrong schemeID');
        }

        return new self($identifier, $scheme);
    }
}
