<?php

namespace App\Providers;

use App\Circle;
use App\Meeting;
use App\Policies\CirclesPolicy;
use App\Policies\MeetingsPolicy;
use App\Policies\MeetingssPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Circle::class => CirclesPolicy::class,
        Meeting::class => MeetingsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
