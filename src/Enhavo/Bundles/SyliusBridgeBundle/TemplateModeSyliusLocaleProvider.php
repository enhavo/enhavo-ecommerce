<?php

namespace Enhavo\Bundles\SyliusBridgeBundle;

use Sylius\Component\Locale\Provider\LocaleProviderInterface;

class TemplateModeSyliusLocaleProvider implements LocaleProviderInterface
{
    public function getAvailableLocalesCodes(): array
    {
        return [];
    }

    public function getDefaultLocaleCode(): string
    {
        return 'en';
    }
}
