<?php namespace GSVnet\Forum\Replies;

use App\Models\Reply;
use App\Models\User;
use GSVnet\Core\EloquentRepository;

class ReplyRepository extends EloquentRepository
{
    public function __construct(Reply $model)
    {
        $this->model = $model;
    }

    /**
     * Add `$user` as a liker of `$reply`.
     */
    public function like(User $user, Reply $reply)
    {
        $reply->likers()->save($user);
    }

    public function incrementLikeCount($replyId)
    {
        $this->model->where('id', $replyId)->increment('like_count');
    }

    public function decrementLikeCount($replyId)
    {
        $this->model->where('id', $replyId)->decrement('like_count');
    }
}