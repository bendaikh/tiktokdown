<?php

namespace App\Service\Theme;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    public Theme|null $theme = null;
    public ThemeManager|null $themeManager = null;

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        /** @var Theme $theme */
        $theme = $this->app->make('theme');
        $this->theme = $theme;
        $this->themeManager = $theme->manager;

        // Ensure theme assets are publicly available
        // If the public/theme-assets symbolic link (or directory) is missing (e.g. on fresh production deploy)
        // we try to recreate it automatically so that images and css are served correctly without requiring
        // a separate deployment step.
        $publicAssetsPath = public_path('theme-assets');
        if (!file_exists($publicAssetsPath)) {
            $sourceAssetsPath = $theme->resourcesPath('assets');
            try {
                // Attempt to create a symlink first (preferred – keeps filesystem lean)
                \Illuminate\Support\Facades\File::link($sourceAssetsPath, $publicAssetsPath);
            } catch (\Throwable $e) {
                // Some environments (shared hosting, Windows, restrictive permissions) block symlinks.
                // As a fallback we copy the directory so that assets are still available.
                \Illuminate\Support\Facades\File::copyDirectory($sourceAssetsPath, $publicAssetsPath);
            }
        }

        // Load theme views
        $this->loadViewsFrom(
            $theme->resourcesPath('views'),
            'theme'
        );

        // Load theme locales
        $this->loadJsonTranslationsFrom($theme->path('lang'));

        // Provide theme config to views
        View::composer(['theme::*'], function ($view) {
            $view->with('theme', $this->theme);
        });

        Route::macro('localization', function () {
            return Route::prefix('{locale?}')->where(['locale', '[a-z]{2}']);
        });
    }
}
