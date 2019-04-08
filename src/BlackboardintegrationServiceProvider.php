<?php
namespace uisits\blackboardintegration;

use Illuminate\Support\ServiceProvider;
use uisits\blackboardintegration\Http\Controllers\BlackboardintegrationController;

class BlackboardintegrationServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->publishes([
            __DIR__ . '/config/bbconfig.php' => config_path('bbconfig.php')
        ], 'bbconfig');
    }

    public function register()
    {

        $this->app->bind('blackboard-facade', function () {
            return new BlackboardintegrationController;
        });
    }
}
