<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoice;

interface CrossIndustryInvoiceInterface
{
    public function toXML(): \DOMDocument;

    public static function fromXML(\DOMDocument $document): self;
}
