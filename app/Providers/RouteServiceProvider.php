<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $moduleNamespace = 'App\Modules';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapWebTemporaryRoutes();

        $this->mapWebModuleRoutes();

        $this->mapApiModuleRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapWebTemporaryRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(base_path('routes/temporary.php'));
    }


    protected function mapWebModuleRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(function () {
                require(base_path('app/Modules/UserModule/routes/web.php'));
                require(base_path('app/Modules/CustomerModule/routes/web.php'));
                require(base_path('app/Modules/ParametersModule/routes/web.php'));
                require(base_path('app/Modules/ZoneModule/routes/web.php'));
                require(base_path('app/Modules/MessengerModule/routes/web.php'));
                require(base_path('app/Modules/DepartmentModule/routes/web.php'));
                require(base_path('app/Modules/ActivityLogModule/routes/web.php'));
                require(base_path('app/Modules/RateModule/routes/web.php'));
                require(base_path('app/Modules/MyServiceModule/routes/web.php'));
            });
    }

    protected function mapApiModuleRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(function () {
                base_path('app/Modules/UserModule/routes/api.php');
            });
    }
}
