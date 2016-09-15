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
    protected $article;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
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

    private function getUsers()
    {
        $users = new User;
        // Personal articles can be attached to users, or to entire user group.
        if ($this->article->is_personal) {
            $attachedUsers = $this->article->users()->select('user_id')->lists('user_id');
            // Getting attached users.
            if (count($attachedUsers)) {
                $users->find($attachedUsers);
            } // Getting group users attached to article.
            else {
                $usersWithRoles = (new User)->getListWithRoles();
                $usersIDs       = $usersWithRoles[$this->article->village->id][$this->article->role_id];
                if (count($usersIDs)) {
                    $users->find(array_keys($usersIDs));
                }
            }
        } else if (is_object($this->article->village)) {
            $villageId = $this->article->village->id;
            $users->where('village_id', $villageId);
        }
        $users->where('active', 1);
        $users = $users->get();
        return $users;
    }

    private function sendNotification(User $user)
    {
        if (is_object($user->devices)) {
            $devices = $user->devices;
            $message = 'Важная новость! ' . $this->article->title;
            if ($this->article->is_personal) {
                $message = 'Персональная новость! ' . $this->article->title;
            }
            foreach ($devices as $device) {
                PushNotification::app($device->type)
                                ->to($device->token)
                                ->send($message);
            }
        }
    }
}
