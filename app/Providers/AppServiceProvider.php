<?php

namespace App\Providers;

use App\Models\UserSettings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Number;
use Spatie\Activitylog\Models\Activity;
use JulioMotol\AuthTimeout\Middlewares\CheckAuthTimeout;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\App\Services\AsteriskService::class, function ($app) {
            return new \App\Services\AsteriskService();
        });
    }

    public function boot(): void
    {
        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('IP Address', request()->ip());
        });

        CheckAuthTimeout::setRedirectTo(function ($request, $guard){
            return match($guard){
                'custom-guard' => route('some.route'),
                default => route('login')
            };
        });

        Number::useLocale($this->app->getLocale());
    }
}
