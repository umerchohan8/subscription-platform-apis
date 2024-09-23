<?php

namespace App\Console\Commands;

use App\Models\PostSubscriberNotification;
use App\Models\User;
use App\Models\Website;
use App\Notifications\NewPostPublished;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEmailsToSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-emails-to-subscribers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send posts to subscribers using their email.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $websites = Website::with(['posts', 'subscriptions'])->get();

        foreach ($websites as $website) {
            foreach ($website->posts as $post) {
                foreach ($website->subscriptions as $subscription) {
                    // Verify if the post has already been sent to the subscriber
                    $hasSent = PostSubscriberNotification::where('post_id', $post->id)
                        ->where('user_id', $subscription->id)
                        ->exists();
                    if (!$hasSent) {
                        $user = User::find($subscription->user_id);

                        if ($user) {
                            $user->notify(new NewPostPublished($post));
                        }

                        // Record that the post has been sent to this subscriber
                        PostSubscriberNotification::create([
                            'uuid' => Str::uuid(),
                            'post_id' => $post->id,
                            'user_id' => $subscription->id,
                        ]);
                    }
                }
            }
        }
    }
}
