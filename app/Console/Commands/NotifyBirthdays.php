<?php

namespace App\Console\Commands;

use App\Events\NotificationEvent;
use App\Models\User;
use Illuminate\Console\Command;

class NotifyBirthdays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:birthdays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications about friends birthdays';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $daysBefore = 3;

        $users = User::whereHas('profile', function ($query) use ($daysBefore) {
            $query->where(\DB::raw('MOD(DAYOFYEAR(birth_date) - DAYOFYEAR(CURRENT_DATE()) + 366, 366)'), $daysBefore);
        })->get();

        foreach ($users as $user) {
            foreach ($user->friends as $friend) {
                event(new NotificationEvent($user->profile, $friend, ['type' => 'birthday']));
            }
            $this->output->comment("{$user->profile->full_name} has birthday in $daysBefore days, "
                                   . "sent notifications to " . count($user->friends) . " friends");
        }
    }
}
