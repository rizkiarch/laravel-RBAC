<?php

namespace App\Providers;

use Illuminate\Foundation\PackageManifest;
use Illuminate\Support\ServiceProvider;

class CustomPackageManifestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PackageManifest::class, function ($app) {
            return new class($app->make('files'), $app->basePath(), $app->getCachedPackagesPath()) extends PackageManifest {
                protected function write(array $manifest)
                {
                    try {
                        parent::write($manifest);
                    } catch (\ErrorException $e) {
                        if (str_contains($e->getMessage(), 'chmod(): Operation not permitted')) {
                            // Try to write without chmod
                            $this->files->put($this->manifestPath, '<?php return ' . var_export($manifest, true) . ';');
                        } else {
                            throw $e;
                        }
                    }
                }
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
