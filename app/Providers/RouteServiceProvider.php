<?php

namespace CodeShopping\Providers;

use CodeShopping\Models\Category;
use CodeShopping\Models\Product;
use CodeShopping\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\database\Eloquent\Builder;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'CodeShopping\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::bind('category', function($value){
            /** @var Collection @collection */
            $collection = Category::whereId($value)->orWhere('slug',$value)->get();
            return $collection->first();
        });
        Route::bind('product', function($value){
            /** @var Collection @collection */
            $query = Product::query();
            $query = $this->onlyTrashedIfRequested($query);
            $collection = $query->whereId($value)->orWhere('slug',$value)->get();
            return $collection->first();
        });
        Route::bind('user', function($value){
            /** @var Collection @collection */
            $query = User::query();
            $query = $this->onlyTrashedIfRequested($query);
            return $query->find($value);
        });
    }

    private function onlyTrashedIfRequested(Builder $query){
        if(\Request::get('trashed')== 1){
            $query = $query->onlyTrashed();
        }
        return $query;
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

        //
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
}
