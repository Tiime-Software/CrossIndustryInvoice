<?php

namespace Tiime\CrossIndustryInvoice\Tests\Renderer;

use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\Renderer\CrossIndustryInvoiceRendererInterface;
use Tiime\CrossIndustryInvoice\Renderer\TwigRenderer;
use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\FilesystemLoader;

class TwigRendererTest extends TestCase
{
    private static ?CrossIndustryInvoiceRendererInterface $renderer;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $twig = new Environment(new FilesystemLoader(__DIR__ . '/../../src/Resources/views'));
        $twig->addExtension(new IntlExtension());

        self::$renderer = new TwigRenderer($twig);
    }

    public function testRender(): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/../Fixtures/EN16931/CIIEN16931Invoice.xml'));

        $invoice = CrossIndustryInvoice::fromXML($document);

        $this->assertIsString(self::$renderer->render($invoice, 'en16931_invoice.html.twig'));
    }

    public function testRenderWithLogo(): void
    {
        $document = new \DOMDocument();
        $document->loadXML(file_get_contents(__DIR__ . '/../Fixtures/EN16931/CIIEN16931Invoice.xml'));

        $invoice = CrossIndustryInvoice::fromXML($document);

        $this->assertIsString(
            self::$renderer->render(
                crossIndustryInvoice: $invoice,
                template: 'en16931_invoice.html.twig',
                context: ['invoice_logo' => __DIR__ . '/../Fixtures/invoice_logo.png']
            )
        );
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$renderer = null;
    }
}
