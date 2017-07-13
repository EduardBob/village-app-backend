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
     * @return void
     */
    public function handle()
    {
        // The document could been deleted
        if (!$this->document || !$this->document->title) {
            return;
        }

        $users = $this->getUsers();
        if (!$users) {
            return;
        }

        $messageText = date('H:i'). ': ';
        $messageText .= 'Персональный документ! ' . PHP_EOL . $this->document->title;
        // Push notification with custom link inside app.
        $message = PushNotification::Message($messageText, array(
            'category' => '/document/' . $this->document->id
        ));

        foreach ($users as $user) {
            $this->sendNotification($message, $user);
        }
    }

    /**
     * Getting users to send notifications.
     * @return \Modules\Village\Entities\User
     */
    private function getUsers()
    {
        $users = new User;
        $sendToUsers = false;
        // Personal documents can be attached to users, or to entire user group.
        $attachedUsers = $this->document->users()->select('user_id')->lists('user_id')->all();
        $attachedBuildings = $this->document->buildings()->select('building_id')->lists('building_id')->all();

        // Getting attached users.
        if (count($attachedUsers)) {
            $sendToUsers = $users->find($attachedUsers);
        } // Get items attached to buildings
        elseif (count($attachedBuildings)) {
            $usersWithRoles = (new User)->getListWithRolesAndBuildings();
            $selectedRole   = $this->document->role_id;
            $usersIDs       = [];
            // User role selected
            if ($selectedRole > 0) {
                foreach ($usersWithRoles[$this->document->village->id][$selectedRole] as $building => $usersInBuildings) {
                    $usersIDs += array_keys($usersInBuildings);
                }
            } else {
                foreach ($usersWithRoles[$this->document->village->id] as $role_id => $buildingWithUsers) {
                    foreach ($buildingWithUsers as $building => $usersInBuildings) {
                        $usersIDs += array_keys($usersInBuildings);
                    }
                }
            }
            if (count($usersIDs)) {
                $sendToUsers = $users->find($usersIDs);
            }
        } // Getting group users attached to document.
        else {
            $usersWithRoles = (new User)->getListWithRoles();
            $usersIDs       = $usersWithRoles[$this->document->village->id][$this->document->role_id];
            if (count($usersIDs)) {
                $sendToUsers = $users->find(array_keys($usersIDs));
            }
        }

        return $sendToUsers;
    }

    /**
     * Sending notifications.
     *
     * @param object $message
     * @param \Modules\Village\Entities\User $user
     */
    private function sendNotification($message, User $user)
    {
        if (is_object($user->devices)) {
            $devices = $user->devices;

            foreach ($devices as $device) {
                PushNotification::app($device->type)
                    ->to($device->token)
                    ->send($message)
                ;
            }
        }
    }
}
