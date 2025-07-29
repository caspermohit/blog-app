<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\BirthdayWishes;   
class SendBirthdayWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:birthdaywishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday wishes to users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $users = User::whereMonth('date_of_birth', now()->month)->whereDay('date_of_birth', now()->day)->get();
            foreach ($users as $user) {
                $user->notify(new BirthdayWishes());
        }
                return Command::SUCCESS;
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'Birthday wishes not sent'], 404);
        }
    }
}
