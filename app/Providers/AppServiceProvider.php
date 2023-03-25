<?php

namespace App\Providers;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use \Carbon\Carbon;

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
    JsonResource::withoutWrapping();
    Validator::extend('olderthan', function ($attribute, $value, $parameters, $validator) {
      $minAge = !empty($parameters) ? (int)$parameters[0] : 13;
      return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
    });
  }
}
