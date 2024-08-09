<?php

namespace Darko\FilamentContentToolkits;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\SEOTools;
use Darko\FilamentContentToolkits\Commands\FilamentContentToolkitsCommand;
use Darko\FilamentContentToolkits\Facades\Site;
use Darko\FilamentContentToolkits\Testing\TestsFilamentContentToolkits;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentContentToolkitsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-content-toolkits';

    public static string $viewNamespace = 'filament-content-toolkits';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasViews()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile();
            });

        $package->hasConfigFile('site');
    }

    public function packageRegistered(): void
    {
    }

    protected static function preparePackage(): void
    {
        //localize routes
        URL::macro('localize', function ($uri, $locale = null) {
            if (str_starts_with($uri, '/')) {
                $locale = $locale ?: App::getLocale();
                return $locale === Site::baseLocale() ? $uri : "/{$locale}{$uri}";
            }
            return $uri;
        });

        //seo macro
        SEOTools::macro('webPage', function (string $title, string $description, string $url) {
            SEOMeta::setTitle($title);
            SEOMeta::setDescription($description);
            SEOMeta::setCanonical($url);
            OpenGraph::setDescription($description);
            OpenGraph::setTitle($title);
            OpenGraph::setUrl($url);
            OpenGraph::addProperty('type', 'webpage');
        });
    }

    public function packageBooted(): void
    {

        static::preparePackage();

        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Testing
        Testable::mixin(new TestsFilamentContentToolkits());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'darko/filament-content-toolkits';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-content-toolkits', __DIR__ . '/../resources/dist/components/filament-content-toolkits.js'),
            Css::make('filament-content-toolkits-styles', __DIR__ . '/../resources/dist/filament-content-toolkits.css'),
            // Js::make('filament-content-toolkits-scripts', __DIR__ . '/../resources/dist/filament-content-toolkits.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FilamentContentToolkitsCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_filament-content-toolkits_table',
        ];
    }
}
