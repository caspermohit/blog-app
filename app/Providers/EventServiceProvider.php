<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\UserActivityEvent;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;  
use App\Listeners\LogUserActivity;
use App\Events\PostCreated;
use App\Listeners\LogPostCreated; 

    
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserActivityEvent::class => [
            LogUserActivity::class,
        ],
        PostCreated::class => [
            LogPostCreated::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        
        Event::listen(Login::class, function ($event) {
            event(new UserActivityEvent($event->user, 'logged in'));
        });
        Event::listen(Logout::class, function ($event) {
            event(new UserActivityEvent($event->user, 'logged out'));
        });
         Event::listen(Registered::class, function ($event) {
            event(new UserActivityEvent($event->user, 'registered'));
        });
        
        
        
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
