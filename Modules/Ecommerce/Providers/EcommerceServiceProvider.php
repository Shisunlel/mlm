<?php

namespace Modules\Ecommerce\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Ecommerce\Entities\Category;
use Modules\Ecommerce\Entities\Frontend;
use Modules\Ecommerce\Entities\GeneralSetting;
use Modules\Ecommerce\Entities\Language;
use Modules\Ecommerce\Entities\Order;
use Modules\Ecommerce\Entities\User;

class EcommerceServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Ecommerce';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'ecommerce';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $activeTemplate = activeTemplate();

        $viewShare['general'] = GeneralSetting::first();
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();

        $viewShare['categories'] = Category::with(['allSubcategories', 'products' => function ($q) {
            return $q->whereHas('categories')->whereHas('brand');
        }, 'products.reviews', 'products.offer', 'products.offer.activeOffer'])->where('parent_id', null)->get();
        view()->share($viewShare);

        view()->composer('ecommerce::admin.partials.sidenav', function ($view) {
            $view->with([
                'banned_users_count' => User::banned()->count(),
                'pending_orders_count' => Order::where('status', 0)->where('payment_status', '!=', 0)->count(),
                'processing_orders_count' => Order::where('status', 1)->where('payment_status', '!=', 0)->count(),
                'dispatched_orders_count' => Order::where('status', 2)->where('payment_status', '!=', 0)->count(),
            ]);
        });

        $pages = $seo = Frontend::where('data_keys', 'pages.element')->get();
        view()->composer([$this->moduleNameLower . '::' . $activeTemplate . 'partials.header', $this->moduleNameLower . '::' . $activeTemplate . 'partials.footer'], function ($view) use ($pages) {
            $view->with([
                'pages' => $pages,
            ]);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
