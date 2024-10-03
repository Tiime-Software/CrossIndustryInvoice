<?php

namespace Tiime\CrossIndustryInvoice\Renderer;

use Tiime\CrossIndustryInvoice\CrossIndustryInvoiceInterface;
use Twig\Environment;

class TwigRenderer implements CrossIndustryInvoiceRendererInterface
{
    public function __construct(
        private Environment $environment,
    ) {
    }

    public function render(CrossIndustryInvoiceInterface $crossIndustryInvoice, string $template, array $context = []): string
    {
        return $this->environment->render($template, ['invoice' => $crossIndustryInvoice, ...$context]);
    }
}
