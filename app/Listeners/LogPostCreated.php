<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserActivityEvent;
use Illuminate\Support\Facades\Log;

class LogPostCreated

{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
            //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        $user = $event->user;   
        $post = $event->post;
        $user->activityLogs()->create([
            'action' => 'created a post: ' . $post->title,
        ]);
    }
}
