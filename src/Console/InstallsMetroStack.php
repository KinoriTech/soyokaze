<?php

namespace KinoriTech\Soyokaze\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

trait InstallsMetroStack
{
    /**
     * Install the Metro 4 Soyokaze stack.
     *
     * @return void
     */
    protected function installMetroStack()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                'metro4' => '^4.5.0',
                'autoprefixer' => '^10.1.0',
                'postcss' => '^8.2.1',
                'postcss-import' => '^14.0.1',
            ] + $packages;
        });

        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/Auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/metro4/App/Http/Controllers/Auth', app_path('Http/Controllers/Auth'));

        // Middleware...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Middleware'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/metro4/App/Http/Middleware', app_path('Http/Middleware'));
        $this->installAjaxMiddleware();

        // RouteServiceProvider...
        $this->addAjaxRoute();

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests/Auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/metro4/App/Http/Requests/Auth', app_path('Http/Requests/Auth'));

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/metro4/resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/metro4/resources/views/layouts', resource_path('views/layouts'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/metro4/resources/views/components', resource_path('views/components'));

        copy(__DIR__ . '/../../stubs/metro4/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
        copy(__DIR__ . '/../../stubs/metro4/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));

        // Components...
        (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/metro4/App/View/Components', app_path('View/Components'));

        // Tests...
        $this->installTests();

        // Routes...
        copy(__DIR__ . '/../../stubs/metro4/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__ . '/../../stubs/metro4/routes/auth.php', base_path('routes/auth.php'));
        copy(__DIR__ . '/../../stubs/metro4/routes/ajax.php', base_path('routes/ajax.php'));

        // "Dashboard" Route...
        $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        // Webpack...
        copy(__DIR__ . '/../../stubs/metro4/webpack.mix.js', base_path('webpack.mix.js'));
        copy(__DIR__ . '/../../stubs/metro4/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__ . '/../../stubs/metro4/resources/css/app.less', resource_path('css/app.less'));
        (new Filesystem)->ensureDirectoryExists(resource_path('images'));
        copy(__DIR__ . '/../../art/socialcard.png', resource_path('images/socialcard.png'));

        $this->info('Soyosake scaffolding installed successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Add the ajax middleware to the $middlewareGroups and the $routeMiddleware in the application Http Kernel.
     *
     * @return void
     */
    protected function installAjaxMiddleware()
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');

        $ajaxMiddleware = "        'ajax' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],";

        $modifiedMiddlewareGroups = $middlewareGroups.PHP_EOL.$ajaxMiddleware.PHP_EOL;

        $modifiedHttpKernel = str_replace(
            $middlewareGroups,
            $modifiedMiddlewareGroups,
            $httpKernel
        );

        $routeMiddleware = Str::before(Str::after($httpKernel, '$routeMiddleware = ['), '];');
        $modifiedRouteMiddleware = $routeMiddleware."    'ajax' => \App\Http\Middleware\Ajax::class,".PHP_EOL;

        $modifiedHttpKernel = str_replace(
            $routeMiddleware,
            $modifiedRouteMiddleware,
            $modifiedHttpKernel
        );

        file_put_contents(app_path('Http/Kernel.php'), $modifiedHttpKernel);

    }

    /**
     * Add the ajax route to the RouteServiceProvider
     *
     * @return void
     */
    protected function addAjaxRoute()
    {
        $routeServiceProvider = file_get_contents(app_path('Providers/RouteServiceProvider.php'));

        $bootFunction = Str::before(Str::after($routeServiceProvider, 'public function boot()'), '}'.PHP_EOL);

        $ajaxRoute = 'Route::prefix(\'ajax\')
                ->name(\'ajax.\')
                ->middleware(\'ajax\')
                ->namespace($this->namespace)
                ->group(base_path(\'routes/ajax.php\'));';

        $modifiedBootFunction = str_replace(
            '$this->routes(function () {',
            '$this->routes(function () {'.PHP_EOL.'             '.$ajaxRoute.PHP_EOL,
            $bootFunction,
        );
        file_put_contents(app_path('Providers/RouteServiceProvider.php'), str_replace(
            $bootFunction,
            $modifiedBootFunction,
            $routeServiceProvider
        ));
    }


}
