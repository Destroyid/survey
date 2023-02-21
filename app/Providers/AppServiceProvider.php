<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

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
        Schema::defaultStringLength(191);

        Validator::extend('company_reg_no','App\Validators\CompanyRegistrationNumberValidator@validate');

        Validator::extend('empty_if', function ($attribute, $value, $parameters, $validator) {
            $fields = $validator->getData(); //data passed to your validator

            foreach ($parameters as $param) {
                $excludeValue = Arr::get($fields, $param, false);
                // dd($excludeValue);

                if ($excludeValue) { //if exclude value is present validation not passed
                    return true;
                }
            }

            return true;
        });

        Validator::replacer('empty_if', function ($message, $attribute, $rule, $parameters) {
            $replace = [$attribute, $parameters[0]];
            $message = "The field :attribute cannot be filled if :other is also filled";
            return  str_replace([':attribute', ':other'], $replace, $message);
        });
    }
}
