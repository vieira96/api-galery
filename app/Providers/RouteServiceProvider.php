<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    protected $router;

    public function boot()
    {
        $this->configureRateLimiting();

        $this->router = Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace);

        //mapear o path dos arquivos de rotas
        $this->mapRouterPath(base_path('routes'));
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(120)->by(optional($request->user())->id || $request->ip());
        });
    }

    private function mapRouterPath(string $path)
    {
        //pego todos os arquivos que tem dentro do path
        $files = glob($path . '/*');

        $this->readPathFiles($files);
    }

    //leio todos os arquivos de dentro de todas as pastas que esta dentro do base path routes
    private function readPathFiles(array $files): void
    {
        foreach ($files as $file) {
            $ext = pathinfo($file);
            isset($ext['extension']) && $ext['extension'] === 'php' ? $this->router->group($file)
                : $this->mapRouterPath($file);
        }
    }
}
