<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification_id;
    protected $users_id;

    /**
     * Create a new job instance.
     */
    public function __construct($notification_id,$users_id)
    {
        $this->notification_id = $notification_id;
        $this->users_id = $users_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notification = Notification::findOrFail($this->notification_id);
        if ($notification) {

            $users = User::whereIn('id',$this->users_id)->get();
            if($users->count()){
                foreach ($users as $user){
                    UserNotification::create([
                        'user_id'=>$user->id,
                        'notification_id' => $notification->id
                    ]);
                }
            }

            logger('Notifications has been sent!');
        }
    }
}
