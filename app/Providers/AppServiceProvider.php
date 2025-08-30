<?php

namespace App\Providers;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Offering;
use App\Observers\OfferingObserver;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Offering::observe(OfferingObserver::class);

        // $timezone = config('app.timezone');

        // // مثال: لو المستخدم مسجل دخوله
        // if (auth()->check() && auth()->user()->timezone) {
        //     $timezone = auth()->user()->timezone;
        // }

        // // أو لو جاي من الـ Session (لو أنت بتمررها من الـ frontend مثلاً)
        // elseif (session()->has('client_timezone')) {
        //     $timezone = session('client_timezone');
        // }

        // // ضبط التايمزون للـ Laravel كله
        // date_default_timezone_set($timezone);
        // Carbon::setTimeZone($timezone);

        \Carbon\Carbon::setLocale(config('app.locale'));

        Gate::define('overview_page', function ($user,$merchant) {
            return Role::find($user->additional_data['role'] ?? 0)->permissions->contains('key', 'overview_page');
        });

    }
}
