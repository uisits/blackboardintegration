<?php
    namespace uisits\blackboardintegration;
    use Illuminate\Support\ServiceProvider;

    class BlackboardintegrationServiceProvider extends ServiceProvider {

        public function boot()
        {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        }

        public function register()
        {
            // $this->app->make(__DIR__.'/Http/controllers/BlackboardintegrationController.php');
        }
    }
    ?>