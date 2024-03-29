<?php

namespace App\Providers;

use App\Circle;
use App\Comment;
use App\Invitation;
use App\Meeting;
use App\Membership;
use App\Observers\CircleObserver;
use App\Observers\CommentObserver;
use App\Observers\InvitationObserver;
use App\Observers\MeetingObserver;
use App\Observers\MembershipObserver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        date_default_timezone_set(Config::get('app.timezone'));
        setlocale(LC_TIME, 'pl_PL');
        Carbon::setLocale('pl');

        Circle::observe(CircleObserver::class);
        Invitation::observe(InvitationObserver::class);
        Meeting::observe(MeetingObserver::class);
        Membership::observe(MembershipObserver::class);
        Comment::observe(CommentObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
