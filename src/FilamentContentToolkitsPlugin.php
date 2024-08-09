<?php

namespace Darko\FilamentContentToolkits;

use Darko\FilamentAutoTranslate\FilamentAutoTranslatePlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Z3d0X\FilamentFabricator\FilamentFabricatorPlugin;

class FilamentContentToolkitsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-content-toolkits';
    }

    public function register(Panel $panel): void
    {
        $panel->plugins([
            FilamentAutoTranslatePlugin::make(),
            FilamentFabricatorPlugin::make(),
        ]);
    }

    public function boot(Panel $panel): void {}

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
