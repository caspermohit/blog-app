<?php

namespace App\Events;
use Illuminate\Queue\SerializesModels;
class UserActivityEvent
{
use SerializesModels;
public $user;
public $action;
public function __construct($user, $action)
{
$this->user = $user;
$this->action = $action;
}
}