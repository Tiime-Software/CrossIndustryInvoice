<?php

namespace Tiime\CrossIndustryInvoice\Renderer;

use Tiime\CrossIndustryInvoice\CrossIndustryInvoiceInterface;
use Twig\Environment;

class TwigRenderer implements CrossIndustryInvoiceRendererInterface
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function render(CrossIndustryInvoiceInterface $crossIndustryInvoice, string $template, array $context = []): string
    {
        return $this->environment->render($template, ['invoice' => $crossIndustryInvoice, ...$context]);
    }
}
