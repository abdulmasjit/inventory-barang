<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Paginator::useBootstrap();
        Paginator::defaultView('layouts.pagination');
        // Currency
        Blade::directive('format_rupiah', function ( $expression ) {
           if($expression!=null){
             return "<?php echo number_format($expression,0,',','.'); ?>"; 
            }else{
             return "<?php echo 0 ?>"; 
           }
        });
    }
}
