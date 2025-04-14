<?php

declare(strict_types=1);

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {}

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        // Validator::extend('olderthan', function ($attribute, $value, $parameters, $validator) {
        //   $minAge = !empty($parameters) ? (int)$parameters[0] : 13;
        //   return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
        // });

        Schema::defaultStringLength(191);
        // Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
        //   $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
        //   return new LengthAwarePaginator(
        //     $this->forPage($page, $perPage), $total ?: $this->count(), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => $pageName]
        //   );
        // });
    }
}
