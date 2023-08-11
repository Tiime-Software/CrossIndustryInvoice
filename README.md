# Tiime/CrossIndustryInvoice library

## How to add this library in Symfony ?

Download this library :
```bash
composer require tiime/cross-industry-invoice
```

If you want to use templates which are available in `src/Resources/views/` folder, you will need to add this configuration :
```yaml
twig:
    # ...
    paths:
        '%kernel.project_dir%/vendor/tiime/cross-industry-invoice/src/Resources/views/': 'TiimeCII'
```

If you want to use templates from this library, you will also need to download `twig/extra-bundle` package :
```bash
composer require twig/extra-bundle
```

In `config/services.yaml`, add this configuration :
```yaml
Tiime\CrossIndustryInvoice\Renderer\TwigRenderer:
    arguments:
        $environment: '@twig'

Tiime\CrossIndustryInvoice\Renderer\CrossIndustryInvoiceRendererInterface: '@Tiime\CrossIndustryInvoice\Renderer\TwigRenderer'
```

### How to use it ?

```php
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\Renderer\CrossIndustryInvoiceRendererInterface;

class MyService
{
    public function __construct(private readonly CrossIndustryInvoiceRendererInterface $renderer)
    {
    }
    
    public function doSomething()
    {
        // Create CrossIndustryInvoice object with needed parameters
        $crossIndustryInvoice = new CrossIndustryInvoice(...);
        
        $this->renderer->render($crossIndustryInvoice, '@TiimeCII/en16931_invoice.html.twig')
    }
}
```