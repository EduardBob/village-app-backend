<?php

namespace Modules\Village\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Village\Entities\Article;
use Modules\Village\Entities\User;
use PushNotification;

class SendArticleNotifications extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue, SerializesModels;
    /**
     * @var \Modules\Village\Entities\Article
     */
    protected $article;

    /**
     * Create a new job instance.
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        $users = $this->getUsers();
        if ($users) {
            foreach ($users as $user) {
                $this->sendNotification($user);
            }
        }
    }

    /**
     * Getting users to send notifications.
     * @return \Modules\Village\Entities\User
     */
    private function getUsers()
    {
        $users       = new User;
        $sendToUsers = false;

        // Personal articles can be attached to users, or to entire user group.
        if ($this->article->is_personal) {
            $attachedUsers     = $this->article->users()->select('user_id')->lists('user_id')->all();
            $attachedBuildings = $this->article->buildings()->select('building_id')->lists('building_id')->all();
            // Getting attached users.
            if (count($attachedUsers)) {
                $sendToUsers = $users->find($attachedUsers);
            } // Get items attached to buildings
            elseif (count($attachedBuildings)) {
                $usersWithRoles = (new User)->getListWithRolesAndBuildings();
                $selectedRole   = $this->article->role_id;
                $usersIDs       = [];
                // User role selected.
                if ($selectedRole > 0) {
                    foreach ($usersWithRoles[$this->article->village->id][$selectedRole] as $building => $usersInBuildings) {
                        $usersIDs += array_keys($usersInBuildings);
                    }
                } else {
                    foreach ($usersWithRoles[$this->article->village->id] as $role_id => $buildingWithUsers) {
                        foreach ($buildingWithUsers as $building => $usersInBuildings) {
                            $usersIDs += array_keys($usersInBuildings);
                        }
                    }
                }
                if (count($usersIDs)) {
                    $sendToUsers = $users->find($usersIDs);
                }
            } // Getting group users attached to article.
            else {
                $usersWithRoles = (new User)->getListWithRoles();
                $usersIDs       = $usersWithRoles[$this->article->village->id][$this->article->role_id];
                if (count($usersIDs)) {
                    $sendToUsers = $users->find(array_keys($usersIDs));
                }
            }
        } else if (is_object($this->article->village)) {
            $villageId   = $this->article->village->id;
            $sendToUsers = $users->where('village_id', $villageId);
            $sendToUsers = $sendToUsers->get();

        }

        return $sendToUsers;
    }

    /**
     * Sending notifications.
     *
     * @param \Modules\Village\Entities\User $user
     */
    private function sendNotification(User $user)
    {
        if (is_object($user->devices)) {
            $devices     = $user->devices;
            $messageText = $this->article->title;
            // Push notification with custom link inside app.
            $message = PushNotification::Message($messageText, array(
              'category' => '/newsitem/' . $this->article->id
            ));
            foreach ($devices as $device) {
                PushNotification::app($device->type)
                                ->to($device->token)
                                ->send($message);
            }
        }
    }
}
