<?php

namespace App\Listeners;
use App\Events\UserActivityEvent;
use App\Models\ActivityLog;
class LogUserActivity
{
public function handle(UserActivityEvent $event)
{
ActivityLog::create([
'user_id' => $event->user->id,
'action' => $event->action,
]);
}
}