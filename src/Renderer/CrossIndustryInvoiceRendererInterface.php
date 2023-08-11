<?php

namespace Tiime\CrossIndustryInvoice\Renderer;

use Tiime\CrossIndustryInvoice\CrossIndustryInvoiceInterface;

interface CrossIndustryInvoiceRendererInterface
{
    public function render(CrossIndustryInvoiceInterface $crossIndustryInvoice, string $template, array $context = []): string;
}
