<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostEmail;

class SendMakeNewPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:makepost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a new post to all users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $users = User::all();
            foreach ($users as $user) { 
                Mail::to($user->email)->send(new NewPostEmail());
            }
                $this->info('notification sent to all users');
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'Notification not sent'], 404);
        }
    }
}
