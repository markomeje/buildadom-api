<?php

namespace App\Providers;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\{Paginator, LengthAwarePaginator};
use Illuminate\Database\Eloquent\Collection;
use \Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {}

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    JsonResource::withoutWrapping();
    Validator::extend('olderthan', function ($attribute, $value, $parameters, $validator) {
      $minAge = !empty($parameters) ? (int)$parameters[0] : 13;
      return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
    });

    Schema::defaultStringLength(191);
    Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
      $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
      return new LengthAwarePaginator(
        $this->forPage($page, $perPage), $total ?: $this->count(), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath(), 'pageName' => $pageName]
      );
    });

    Builder::macro('withWhereHas', function($relation, $constraint) {
      $this->whereHas($relation, $constraint)->with([$relation => $constraint]);
    });
  }
}
