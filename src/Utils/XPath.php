<?php

namespace Tiime\CrossIndustryInvoice\Utils;

use Tiime\CrossIndustryInvoice\Exception\MalformedXPath;

class XPath extends \DOMXPath
{
    /**
     * Returns a DOMNodeList containing all nodes matching the given XPath expression. Any expression which does not return nodes will return an empty DOMNodeList.
     * If the expression is malformed or the contextNode is invalid, DOMXPath::query() returns false.
     *
     * https://www.php.net/manual/en/domxpath.query.php
     */
    public function query(string $expression, ?\DOMNode $contextNode = null, bool $registerNodeNS = true): \DOMNodeList
    {
        $data = parent::query($expression, $contextNode, $registerNodeNS);

        if (!$data instanceof \DOMNodeList) {
            throw new MalformedXPath();
        }

        return $data;
    }
}
