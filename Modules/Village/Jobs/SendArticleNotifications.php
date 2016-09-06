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
        $users = new User;
        if (is_object($this->article->village)) {
            $villageId = $this->article->village->id;
            $users->where('village_id', $villageId);
        }
        $users->where('active', 1);
        $users = $users->get();
        foreach ($users as $user) {
            $this->sendNotification($user);
        }
    }

    private function sendNotification(User $user)
    {
        if (is_object($user->devices)) {
            $devices = $user->devices;
            $message = 'Важная новость! ' . $this->article->title;
            foreach ($devices as $device) {
                PushNotification::app($device->type)
                                ->to($device->token)
                                ->send($message);
            }
        }
    }
}
