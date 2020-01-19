<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function created(Reply $reply)
    {
        $reply_count = $reply->topic->replies->count();
        // $reply->topic->save();
        \DB::table('topics')->where(['id' => $reply->topic_id])->update(['reply_count' => $reply_count]);

        $reply->topic->user->notify(new TopicReplied($reply));

    }
}