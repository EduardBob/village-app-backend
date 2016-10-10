<?php

namespace Modules\Village\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Village\Entities\Document;
use Modules\Village\Entities\User;
use PushNotification;

class SendDocumentNotifications extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue, SerializesModels;
    protected $document;

    /**
     * Create a new job instance.
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = $this->getUsers();
        foreach ($users as $user) {
            $this->sendNotification($user);
        }
    }

    /**
     * Getting users to send notifications.
     * @return \Modules\Village\Entities\User
     */
    private function getUsers()
    {
        $users = new User;
        // Personal documents can be attached to users, or to entire user group.
        $attachedUsers = $this->document->users()->select('user_id')->lists('user_id');
        // Getting attached users.
        if (count($attachedUsers)) {
            $users->find($attachedUsers);
        } // Getting group users attached to document.
        else {
            $usersWithRoles = (new User)->getListWithRoles();
            $usersIDs       = $usersWithRoles[$this->document->village->id][$this->document->role_id];
            if (count($usersIDs)) {
                $users->find(array_keys($usersIDs));
            }
        }
        $users->where('active', 1);
        $users = $users->get();

        return $users;
    }

    /**
     * Sending notifications.
     * @param \Modules\Village\Entities\User $user
     */
    private function sendNotification(User $user)
    {
        if (is_object($user->devices)) {
            $devices = $user->devices;
            $message = date('H:i'). ': ';
            $message .= 'Персональный документ! ' . PHP_EOL . $this->document->title;

            foreach ($devices as $device) {
                PushNotification::app($device->type)
                                ->to($device->token)
                                ->send($message);
            }
        }
    }
}
